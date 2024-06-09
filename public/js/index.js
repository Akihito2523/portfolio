

document.addEventListener("DOMContentLoaded", () => {

  //** ============ ハンバーガーメニュー ==================*/

  //** ============ ラジオボタン ==================*/
  const radio = document.querySelector('#js-radio');
  if (radio) {
    // 変更を監視
    const radioChange = (event) => {
      // イベントのターゲットから値を取得
      const target = event.target;
      if (target.name === 'gender') {
        const fruitValue = target.value;
        console.log(`選択された性別は ${fruitValue} です`);
      } else if (target.name === 'drink') {
        const drinkValue = target.value;
        console.log(`選択された飲み物は ${drinkValue} です`);
      }
    }
    radio.addEventListener('change', radioChange);
  } else {
    console.log('ラジオボタンがNULL');
  }
  //** ============ セレクト ==================*/
  const select = document.querySelector('#js-select');
  // 変更を監視
  if (select) {
    const selectChange = (event) => {
      console.log(event.target.value);
      console.log(`セレクトのvalue値は ${select.value} です`);
      const selectOptions = select.options[select.selectedIndex].innerHTML;
      console.log(`セレクトの中身は ${selectOptions} です`);
    }
    select.addEventListener('change', selectChange);
  }
  //** ============ チェックボックス ==================*/
  const checkboxes = document.querySelectorAll('#js-checkbox input[type="checkbox"]');
  let checkbox_output = '';
  if (checkboxes) {
    const checkboxChange = () => {
      checkbox_output = '';
      checkboxes.forEach((checkbox) => {
        if (checkbox.checked) {
          checkbox_output += ' ' + checkbox.value;
        }
      });
      console.log(`選択されたチェックボックス: ${checkbox_output}`);

      //Checkboxのうち、選択されている値を取得
      const form = document.querySelector('form');
      const checkedLanguages = [];
      for (const language of form.checkbox) {
        if (language.checked) {
          checkedLanguages.push(language.value);
          console.log(`${checkedLanguages}`);
        }
      }
    };
    checkboxes.forEach((checkbox) => {
      checkbox.addEventListener('change', checkboxChange);
    });
  }
  //** ============ テキストエリア ==================*/
  const textarea = document.querySelector('#js-textarea');
  /** 入力中の文字数 */
  const textareaCount = document.querySelector('#js-textareaCount');
  //  テキストを入力する度にonKeyUp()を実行する
  if (textarea) {
    const onKeyUp = () => {
      // 入力されたテキスト
      const inputText = textarea.value;
      // 文字数を反映
      textareaCount.innerText = inputText.length;
    }
    textarea.addEventListener('keyup', onKeyUp);
  }
  //** ============ カレンダー ==================*/
  const datetime = document.querySelector('#js-datetime');
  if (datetime) {
    const datetimeChange = (e) => {
      console.log(e.target.value);
      const dt = new Date(e.target.value);
      console.log(dt);
    }
    datetime.addEventListener('change', datetimeChange);
  }
  //** ============ 利用規約（チェックボックス） ==================*/
  const check = document.querySelector('#js-check');
  const $needElements = document.querySelectorAll(".need.js-need");
  const $submit = document.querySelector('#js-submit');
  $submit.style.opacity = '60%';

  if (check) {
    if (!check.checked) {
      $submit.style.opacity = '60%';
      $submit.style.cursor = 'default';
    } else {
      $submit.style.opacity = '100%';
      $submit.style.cursor = 'pointer';
      $submit.disabled = false;
    }
  }

  if (check) {
    const checkChange = (event) => {
      const checked = event.target.checked;
      console.log(`チェックボックス ${checked} です`);
      $submit.disabled = !check.checked;
      if ($submit.disabled) {
        $submit.style.opacity = '60%';
        $submit.style.cursor = 'default';
        // $needElements.forEach(($element) => {
        //   $element.style.display = "inline";
        // });
      } else {
        $submit.style.opacity = '100%';
        $submit.style.cursor = 'pointer';
        // $needElements.forEach(($element) => {
        //   $element.style.display = "none";
        // });
      }
    }
    check.addEventListener('change', checkChange);
  }

  //** ============ form ==================*/
  //テキストのname値を取得
  const form = document.querySelector('form');
  form.addEventListener('submit', (e) => {
    // e.preventDefault();
    console.log(form.elements.text.value);
  });

  //** ============ バリデーションチェック ==================*/
  // $submit.addEventListener('click', (event) => {

  //   // フォームの入力要素とメッセージ要素を取得
  //   const tel = document.querySelector('#js-tel');
  //   const telMessage = document.querySelector('#js-telMessage');
  //   const text = document.querySelector('#js-text');
  //   const textMessage = document.querySelector('#js-textMessage');
  //   const email = document.querySelector('#js-email');
  //   const emailMessage = document.querySelector('#js-emailMessage');

  //   // 共通の検証関数
  //   const validateField = (value, messageElement, errorMessage, validateFunc) => {
  //     if (!validateFunc(value)) {
  //       messageElement.textContent = errorMessage;
  //       return false;
  //     } else {
  //       messageElement.textContent = '';
  //       return true;
  //     }
  //   };

  //   // 各フィールドの検証関数
  //   const isValidTel = (value) => /^[0][0-9]{9,10}$/.test(value.replace(/-/g, ''));
  //   const isNotEmpty = (value) => value.trim() !== "";

  //   // 各フィールドの値を取得
  //   const telValue = tel.value;
  //   const textValue = text.value;
  //   const emailValue = email.value;

  //   // 検証実行
  //   const isTelValid = validateField(telValue, telMessage, '半角数字と + - のみ利用できます', isValidTel);
  //   const isTextValid = validateField(textValue, textMessage, '氏名を入力してください', isNotEmpty);
  //   const isEmailValid = validateField(emailValue, emailMessage, 'メールアドレスを入力してください', isNotEmpty);

  //   // フォーム送信をキャンセルするかどうかを決定
  //   if (!isTelValid || !isTextValid || !isEmailValid) {
  //     event.preventDefault();
  //   }
  // });




});
