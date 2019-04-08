$('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text('New message to ' + recipient)
    modal.find('.modal-body input').val(recipient)
  })

function myFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}

$(document).ready(function() {
  $.ajaxSetup({
      cache: false
  });
  $('#search').keyup(function() {
      $('#result').html('');
      $('#state').val('');
      var searchField = $('#search').val();
      var expression = new RegExp(searchField, "i");
      $.getJSON('data.json', function(data) {
          $.each(data, function(key, value) {
              if (value.account.search(expression) != -1 || value.lastName.search(expression) != -1) {
                  $('#result').append(
                      '<input type="hidden" name="id" value="'+value.userId+'"> <li class="list-group-item link-class"><img src="uploads/' + value.avatar +
                      '" height="40" width="40" class="img-thumbnail" /> ' + value.account + ' | <span class="text-muted">' + value.lastName +'| <a class="float-right" href="editUser.php?id='+ value.userId +'" id="edit">Edit</a></span></li>');
              }
          });
      });
  });

  $('#result').on('click', 'li', function() {
      var click_text = $(this).text().split('|');
      $('#search').val($.trim(click_text[0]));
      $("#result").html('');
  });
});



