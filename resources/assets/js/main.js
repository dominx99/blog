var oneClickButtons = document.querySelectorAll('.one-click');

oneClickButtons.forEach(function (button, i) {
    button.addEventListener('click', oneClickButton);
});

function oneClickButton() {
    this.addClass('disabled');
    this.setAttribute('disabled', true);
    
}

HTMLElement.prototype.addClass = function(className) {
    if (this.classList) {
      this.classList.add(className);
    }
    else {
      this.className += ' ' + className;
    }
}
HTMLElement.prototype.removeClass = function(className) {
    if (this.classList) {
      this.classList.remove(className);
    }
    else {
      this.className = this.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
    }
}
