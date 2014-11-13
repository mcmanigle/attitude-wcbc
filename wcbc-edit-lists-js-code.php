<?php

function wcbc_edit_lists_js_shortcode( $atts, $content = null ) {
	return <<<'EOT'
<script type="text/javascript">
(function($) {

var mcl_names = new Object();

function mcl_validate_email(email)
{ 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function mcl_html_escape(str)
{
    return String(str)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
}

var oldText = '';
function mcl_sanitize_emails()
{
    var currentText = $('#mcl_addresses_area').val();
    if(currentText == oldText)
    {
        return;
    }
    oldText = currentText;
    
    var content = '';
    var lines = currentText.split('\n');
    for(i = 0; i < lines.length; i++)
    {
        var line = lines[i];
        if( line.length && !mcl_validate_email(line) )
        {
            content += '"'+mcl_html_escape(line)+'" doesn\'t look like a valid e-mail address. (Line '+(i+1)+')<br />\n';
        }
    }
    
    $('#mcl_addresses_error_area').html(content);
}

function mcl_display_messages(result, scroll)
{
    scroll = typeof scroll !== 'undefined' ? scroll : true;

    var container = $("#mcl_message_area");
    var contents = '';
    
    for(i = 0; i < result['message'].length; i++)
    {
        contents += '<div class="' + (result['is_error'][i]?'mcl_error':'mcl_message') + '">';
        contents += result['message'][i];
        contents += '</div>';
    }
    
    container.html(contents);
    
    if(scroll)
    {
        $('html, body').animate({
            scrollTop: container.offset().top - 100
        }, 500);
    }
    
    $("#mcl_message_area").children().delay(4000).fadeOut(500);
}

function mcl_display_error(the_error)
{
    var container = $("#mcl_message_area");
    var contents = '<div class="mcl_error">';
    contents += the_error;
    contents += '</div>';
    
    container.html(contents);
    $("#mcl_message_area").children().delay(4000).fadeOut(500);
}

function mcl_please_wait(message)
{
    var container = $("#mcl_message_area");
    var contents = '<div class="mcl_wait">';
    contents += 'Please wait...';
    contents += '</div>';
    
    container.html(contents);
}

function mcl_set_names(result)
{
    mcl_names = result['names'];
}

function mcl_update_lists(result)
{
    if( result['lists'] === null ) return;
    
    var lists = result['lists'];
    var outstanding_names = {};
    for( var key in mcl_names )
        outstanding_names[ key ] = mcl_names[ key ];
    
    var names_selector = $('#mcl_all_names');
    var lists_selector = $('#mcl_all_lists');
    var names_contents = '';
    var lists_contents = '';
    
    for (var list_no in lists) {
        var name_no = lists[list_no];
        lists_contents += '<option id="mcl_list_' + list_no + '" value="' + list_no + '">';
        lists_contents += outstanding_names[name_no] + '</option>\n';
        delete outstanding_names[name_no];
    }
    
    for (var name_no in outstanding_names) {
        names_contents += '<option id="mcl_name_' + name_no + '" value="' + name_no + '">';
        names_contents += outstanding_names[name_no] + '</option>\n';
    }
        
    names_selector.html(names_contents);
    lists_selector.html(lists_contents);
}

function mcl_load_list(result)
{
    if( result['list_id'] === 'no result' )
    {
        $('#mcl_addresses_area').val('').attr('disabled',true);
        $('#mcl_comment_area').val('').attr('disabled',true);
        $('#mcl_broadcast_address').html('');
        $('#mcl_list_created').html('');
        $('#mcl_list_edited').html('');
        $('#mcl_list_sent').html('');
    }
    
    else if( result['list_id'] !== null )
    {
        $('#mcl_addresses_area').val(result['addresses']).attr('disabled',false);
        $('#mcl_comment_area').val(result['comment']).attr('disabled',false);
        var bca = 'list-'+result['name']+'@wolfsonrowing.org';
        $('#mcl_broadcast_address').html('<a href="mailto:'+bca+'">'+bca+'</a>');
        $('#mcl_list_created').html(result['created']);
        $('#mcl_list_edited').html(result['edited']);
        $('#mcl_list_sent').html(result['sent']);
        $('#mcl_all_lists').val(result['list_id']);
    }
    
    mcl_sanitize_emails();
}

$( document ).ready(function() {

  mcl_please_wait();
  $.ajax({
    url:'/lists/action.php',
    type:'POST',
    data:{action:'get_names'},
    success:function(result){
      mcl_display_messages(result, false);
      mcl_set_names(result);
      mcl_update_lists(result);
      
      mcl_please_wait();
      $.ajax({
        url:'/lists/action.php',
        type:'POST',
        data:{action:'load_any_list'},
        success:function(result){
          mcl_display_messages(result, false);
          mcl_update_lists(result);
          mcl_load_list(result);
        },
        error:function(){
          mcl_display_error('Could not connect to the server.');
        }
      });
      
    },
    error:function(){
      mcl_display_error('Could not connect to the server.');
    }
  });

  $('#mcl_all_lists').change(function() {
    mcl_please_wait();
    $.ajax({
      url:'/lists/action.php',
      type:'POST',
      data:{action:'load_list',list_id:$(this).val()},
      success:function(result){
        mcl_display_messages(result);
        mcl_update_lists(result);
        mcl_load_list(result);
      },
      error:function(){
        mcl_display_error('Could not connect to the server.');
      }
    });
  });
  
  $('#mcl_create_button').click(function() {
    mcl_please_wait();
    $.ajax({
      url:'/lists/action.php',
      type:'POST',
      data:{action:'new_list',name_id:$('#mcl_all_names').val()},
      success:function(result){
        mcl_display_messages(result);
        mcl_update_lists(result);
        mcl_load_list(result);
      },
      error:function(){
        mcl_display_error('Could not connect to the server.');
      }
    });
  });
  
  $('#mcl_save_button').click(function() {
    mcl_please_wait();
    $.ajax({
      url:'/lists/action.php',
      type:'POST',
      data:{action:'save_list',list_id:$('#mcl_all_lists').val(),
            addresses:$('#mcl_addresses_area').val(),comment:$('#mcl_comment_area').val()},
      success:function(result){
        mcl_display_messages(result);
        mcl_update_lists(result);
        mcl_load_list(result);
      },
      error:function(){
        mcl_display_error('Could not connect to the server.');
      }
    });
  });

  $('#mcl_delete_button').click(function() {
    if (window.confirm("Are you sure you want to delete the list?  This cannot be undone.")) {
    mcl_please_wait();
      $.ajax({
        url:'/lists/action.php',
        type:'POST',
        data:{action:'delete_list',list_id:$('#mcl_all_lists').val()},
        success:function(result){
          mcl_display_messages(result);
          mcl_update_lists(result);
          mcl_load_list(result);
        },
        error:function(){
          mcl_display_error('Could not connect to the server.');
        }
      });
    }
  });

  $('#mcl_addresses_area').on('change keyup paste', mcl_sanitize_emails);

});

})( jQuery );

</script>
EOT;
}

add_shortcode( 'wcbc-edit-lists-js', 'wcbc_edit_lists_js_shortcode' );
