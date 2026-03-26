<div id="ajax-response"></div>

<style>
  /*h3{ margin: 2.5rem 0 0.5rem; }*/
  .callout{ padding: 5px 10px;
    border-radius: 3px; }
  .loading{ background-color: #eaeaea; }
  .success{ background-color: #e1faea; }
  .alert{ background-color: #f7e4e1; };
</style>


<script>
  $('#respond').submit(function(){

    // alert($(this).serialize());
    // show that something is loading
    $('#ajax-response').html("<b>Saving...</b>");
    $('#ajax-response').removeClass("loading success alert");
    $('#ajax-response').addClass("callout loading");

    // Call ajax for pass data to other place
    $.ajax({
      type: 'POST',
      url: '../baseline/save.php',
      data: $(this).serialize() // getting filed value in serialize form
    })
    .done(function(data, textStatus, jqXHR){ // if getting done then call.
      // show the response
      $('#ajax-response').html(data);
      $('#ajax-response').removeClass("loading alert");
      $('#ajax-response').addClass("success");
      // alert(textStatus);
      // alert(jqXHR.status);
      if (jqXHR.status == 206) {
        $('#ajax-response').removeClass("loading success");
        $('#ajax-response').addClass("alert");
          } else {
            // window.location.href = "/assessment/dashboard/";
          }
    });

    // to prevent refreshing the whole page page
    return false;

  });
</script>