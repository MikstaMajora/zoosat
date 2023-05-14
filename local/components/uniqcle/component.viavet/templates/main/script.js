$(function() {
  const btnViavet = document.querySelector('#btn-viavet');


$('.js-copy').on('click', function() {
  copyToClipboard( $(this).text() );
  ui_copyDone( this );
  // this → объект, в контексте которого вызвана функция (здесь: кликнутый HTML элемент
  // $(this) → оно же, завернутое в jQuery-объект.
});

$('.js-copy-btn').each(function(index) {
  $(this).on('click', function() {
    copyToClipboard( $('.js-copy-target').eq(index).text() );
    ui_copyDone( this );
  });
  // this → очередной элемент, который перебираем
  // index → его номер, который совпадает с номером блока, откуда нужно копировать
});

/***/

function copyToClipboard(str) {
  var area = document.createElement('textarea');

  document.body.appendChild(area);
    area.value = str;
    area.select();
    document.execCommand("copy");
  document.body.removeChild(area);
}

function ui_copyDone(btn) {
  var contentSaved = btn.innerHTML;

  btn.innerHTML = '<span>Промокод VIAVET скопирован</span>';
  btn.classList.add('copied-promocod-viavet');

  setTimeout(function() {
    btn.innerHTML = contentSaved;
    btn.classList.remove('copied-promocod-viavet');
  }, 5500);
}

});

