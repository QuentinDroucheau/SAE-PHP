document.addEventListener('DOMContentLoaded', function() {
  window.showEditButton = function(buttonId) {
    var button = document.getElementById(buttonId);
    if (button) {
      button.style.display = 'inline-block';
    }
  }

  window.hideEditButton = function(buttonId) {
    var button = document.getElementById(buttonId);
    if (button) {
      button.style.display = 'none';
    }
  }

window.openEditModal = function(field) {
  var element = $('.header-playlist .info ' + (field === 'name' ? 'h1' : '.container-description p'));
  var currentValue = element.text();
  element.html('<form onsubmit="submitEditForm(event, \'' + field + '\', this.elements[0].value)"><input type="text" value="' + currentValue + '"><input type="submit" value="Enregistrer"></form>');
}

window.submitEditForm = function(event, field, newValue) {
  event.preventDefault();
  var playlistId = $('.header-playlist').data('id');

  $.ajax({
    url: '/modifierPlaylist',
    method: 'POST',
    data: JSON.stringify({
      id: playlistId,
      [field]: newValue
    }),
    contentType: 'application/json',
    success: function(data) {
      if (data.success) {
        // todo
      }
    }
  });
}
});