/**
 * Created by matkoabramovic on 14/11/14.
 */
function deletePost(id){
  $.ajax({
    type: "POST",
    url: "/posts/delete",
    data: { id: id}
  })
    .done(function( msg ) {
      if(msg=='succes'){
        var idPost = '#post_'+id;
        $(idPost).remove();
      } else {
        alert( msg );
      }

    });
}

