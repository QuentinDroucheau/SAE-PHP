$(document).ready(function () {
  $('#follow-button').click(function () {
    var artistId = $(this).data('artist-id');
    console.log(artistId);
    $.ajax({
      url: '/follow',
      type: 'POST',
      data: {
        artistId: artistId,
      },
      success: function (data) {
        response = JSON.parse(data);
        if(response.action === 'followed'){
          $('#follow-button').html('SUIVI').addClass('followed');
        }else if(response.action === 'unfollowed'){
          $('#follow-button').html('SUIVRE').removeClass('followed');
        }
        $('#followers-count').html(response.followers + ' abonnés');
      }
    });
  });
});