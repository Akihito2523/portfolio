<<<<<<< HEAD


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
=======
/**
 * DOMの読み込みが完了した時に実行される初期処理を設定します。
 */
document.addEventListener("DOMContentLoaded", () => {

  // フォームの送信処理
  const form = document.querySelector('form');
  if (form) {
    form.addEventListener('submit', (e) => {
      // e.preventDefault();
      console.log(form.elements.text.value);
    });
  }

  // 氏名バリデーション
  const text = document.querySelector('#js-text');
  const textMessage = document.querySelector('#js-textMessage');
  if (text) {
    /**
     * 電話番号フィールドのバリデーションを行い、エラーメッセージを設定します。
     * @param {Event} e 入力イベント
     */
    const validateText = (e) => {
      const textValue = text.value;
      console.log(textValue);
      if (!textValue.trim()) {
        textMessage.innerText = '氏名を入力してください';
        text.style.border = '3px solid red';
      } else if (textValue > 64) {
        textMessage.innerText = '氏名は64文字以内で入力してください。';
        text.style.border = '3px solid red';
      } else {
        textMessage.innerText = '';
        text.style.border = '';
      }
    }
    text.addEventListener('blur', validateText);
  }

  // 電話番号バリデーション
  const tel = document.querySelector('#js-tel');
  const telMessage = document.querySelector('#js-telMessage');
  if (tel) {
    /**
     * 電話番号フィールドのバリデーションを行い、エラーメッセージを設定します。
     * @param {Event} e 入力イベント
     */
    const validateTel = (e) => {
      const telValue = e.target.value;
      if (!telValue.trim()) {
        telMessage.innerText = '電話番号を入力してください';
        tel.style.border = '3px solid red';
      } else if (!/^[0-9+\-]+$/.test(telValue)) {
        telMessage.innerText = '半角数字と + - のみ利用できます';
        tel.style.border = '3px solid red';
      } else if (!/^(0\d{9,10}|\d{1,4}-\d{1,4}-\d{4})$/.test(telValue)) {
        telMessage.innerText = '正しい電話番号の形式で入力してください';
        tel.style.border = '3px solid red';
      } else {
        telMessage.innerText = '';
        tel.style.border = '';
      }
    }
    tel.addEventListener('blur', validateTel);
  }

  const email = document.querySelector('#js-email');
  const emailMessage = document.querySelector('#js-emailMessage');

  if (email) {
    /**
     * メールアドレスフィールドのバリデーションを行い、エラーメッセージと枠線のスタイルを設定します。
     * @param {Event} e 入力イベント
     */
    const validateEmail = (e) => {
      const emailValue = email.value.trim(); // メールアドレスの値を取得し、前後の空白を除去する

      if (!emailValue) {
        emailMessage.innerText = 'メールアドレスを入力してください。';
        email.style.border = '3px solid red';
      } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue)) {
        emailMessage.innerText = '有効なメールアドレスを入力してください。';
        email.style.border = '3px solid red';
      } else {
        emailMessage.innerText = '';
        email.style.border = '';
      }
    };

    // 入力時にバリデーション関数を呼び出す
    email.addEventListener('blur', validateEmail);
  }


  /**
   * フォーカスを当てる。
   *  @param {element} event 変更イベント
   * */
  const validateFocus = (element) => {
    element.focus();
  }
  // フォーカスが設定されたかどうかを示すフラグ
  let focused = false;

  if (text) {
    if (textMessage.innerText) {
      if (!focused) {
        validateFocus(text);
        focused = true;
      }
    }
  }

  if (tel) {
    if (telMessage.innerText) {
      if (!focused) {
        validateFocus(tel);
        focused = true;
      }
    }
  }

  if (email) {
    if (emailMessage.innerText) {
      if (!focused) {
        validateFocus(email);
        focused = true;
      }
    }
  }





  // ラジオボタンの選択状態監視
  const radio = document.querySelector('#js-radio');
  if (radio) {
    /**
     * ラジオボタンの選択状態が変化した際に、選択された値をコンソールに出力します。
     * @param {Event} event 変更イベント
     */
    const changeRadioHandler = (event) => {
      const target = event.target;
      if (target.name === 'gender') {
        const genderValue = target.value;
        console.log(`選択された性別は ${genderValue} です`);
>>>>>>> feature
      } else if (target.name === 'drink') {
        const drinkValue = target.value;
        console.log(`選択された飲み物は ${drinkValue} です`);
      }
    }
<<<<<<< HEAD
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
=======
    radio.addEventListener('change', changeRadioHandler);
  }

  // セレクトボックスの選択状態監視
  const select = document.querySelector('#js-select');
  if (select) {
    /**
     * セレクトボックスの選択状態が変化した際に、選択された値をコンソールに出力します。
     * @param {Event} event 変更イベント
     */
    const changeSelectHandler = (event) => {
>>>>>>> feature
      console.log(`セレクトのvalue値は ${select.value} です`);
      const selectOptions = select.options[select.selectedIndex].innerHTML;
      console.log(`セレクトの中身は ${selectOptions} です`);
    }
<<<<<<< HEAD
    select.addEventListener('change', selectChange);
  }
  //** ============ チェックボックス ==================*/
  const checkboxes = document.querySelectorAll('#js-checkbox input[type="checkbox"]');
  let checkbox_output = '';
  if (checkboxes) {
    const checkboxChange = () => {
      checkbox_output = '';
=======
    select.addEventListener('change', changeSelectHandler);
  }

  // チェックボックスの選択状態監視
  const checkboxes = document.querySelectorAll('#js-checkbox input[type="checkbox"]');
  if (checkboxes) {
    /**
     * チェックボックスの選択状態が変化した際に、選択された値をコンソールに出力します。
     */
    const checkboxChangeHandler = () => {
      let checkbox_output = '';
>>>>>>> feature
      checkboxes.forEach((checkbox) => {
        if (checkbox.checked) {
          checkbox_output += ' ' + checkbox.value;
        }
      });
      console.log(`選択されたチェックボックス: ${checkbox_output}`);
<<<<<<< HEAD

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
=======
    };

    //Checkboxのうち、選択されている値を取得
    // const form = document.querySelector('form');
    // const checkedLanguages = [];
    // for (const language of form.checkbox) {
    //   if (language.checked) {
    //     checkedLanguages.push(language.value);
    //     console.log(`${checkedLanguages}`);
    //   }
    // }

    checkboxes.forEach((checkbox) => {
      checkbox.addEventListener('change', checkboxChangeHandler);
    });
  }

  // テキストエリアの文字数カウント
  const textarea = document.querySelector('#js-textarea');
  const textareaCount = document.querySelector('#js-textareaCount');
  if (textarea && textareaCount) {
    /**
     * テキストエリアの入力内容が変化した際に、文字数をカウントして表示します。
     */
    const inputTextareaHandler = () => {
      const textareaValue = textarea.value;
      textareaCount.innerText = textareaValue.length;
    }
    textarea.addEventListener('input', inputTextareaHandler);
  }


  // 利用規約に同意した場合の送信ボタンの操作
  const check = document.querySelector('#js-check');
  const submitButton = document.querySelector('#js-submit');
  if (check && submitButton) {
    submitButton.style.opacity = check.checked ? '100%' : '60%';
    submitButton.disabled = check.checked ? false : true;
    /**
     * 利用規約の同意チェックボックスの状態が変化した際に、送信ボタンの有効/無効とスタイルを更新します。
     * @param {Event} event 変更イベント
     */
    const changeCheckHandler = (event) => {
      const checked = event.target.checked;
      submitButton.disabled = !checked;
      submitButton.style.opacity = checked ? '100%' : '60%';
      submitButton.style.cursor = checked ? 'pointer' : 'default';
    }
    check.addEventListener('change', changeCheckHandler);
  }

  // ファイルの選択とプレビュー表示
  const image = document.querySelector('#js-image');
  const imagePreview = document.querySelector('#js-imagePreview');
  if (image && imagePreview) {
    /**
    * ファイルが選択された時に、画像ファイルであればプレビュー表示を行います。
    * @param {Event} event 変更イベント
    */
    const changeImageHandler = (event) => {
      const file = event.target.files[0];

      // ファイルが存在しないか、画像形式でない場合のエラーチェック
      if (!file || !file.type.match(/^image\//)) {
        alert('画像ファイルを選択してください。');
        return false;
      }

      // FileReaderのインスタンスを生成
      const reader = new FileReader();

      // 読み込みが完了したら画像をプレビューとして表示する
      reader.addEventListener('load', (event) => {
        // 読み込み完了後に画像をプレビュー
        imagePreview.setAttribute('src', event.target.result);
        const imagePathError = document.querySelector('.js-image_path_error');
        if (imagePathError.innerText !== '') {
          imagePathError.innerText = '';
        }
      });
      // ファイル読み込み開始
      reader.readAsDataURL(file);
    };

    // 変更時に画像をプレビュー
    image.addEventListener('change', changeImageHandler);
  }

  // 変更時にフォームを送信
  const selectImageGallery = document.querySelector('#js-select-image-gallery');
  const selectImageGalleryForm = document.querySelector('#js-select-image-gallery-form');
  if (selectImageGallery) {
    const changeSelectImageGalleryHandler = (event) => {
      selectImageGalleryForm.submit();
      console.log(parseInt(event.target.value));
    }
    selectImageGallery.addEventListener('change', changeSelectImageGalleryHandler);
  }


  // 削除ボタンの確認ダイアログ表示
  const btnDelete = document.querySelectorAll('.js-btndelete');
  if (btnDelete) {
    /**
     * 削除ボタンがクリックされた時に、確認ダイアログを表示します。
     * @param {MouseEvent} e クリックイベント
     */
    btnDelete.forEach((btnDelete) => {
      btnDelete.addEventListener('click', (e) => {
        const result = confirm('削除しますか');
        if (!result) {
          e.preventDefault();
        }
      })
    })
  }

  // パスワード表示切替処理
  const passwordAdmin = document.querySelector('#js-password-admin');
  const passwordButtonEye = document.querySelector('#js-passwordButtonEye');
  if (passwordButtonEye && passwordAdmin) {
    /**
     * パスワード表示切替ボタンがクリックされた時に、パスワードフィールドの表示形式を切り替えます。
     */
    const clickPasswordButtonEyeHandler = () => {
      // パスワードフィールドのタイプをトグル（テキスト ⇄ パスワード）
      passwordAdmin.type = passwordAdmin.type === 'password' ? 'text' : 'password';
      // パスワード表示切替アイコンのクラスをトグル（目のアイコン ⇄ 斜線のアイコン）
      passwordButtonEye.classList.toggle('fa-eye-slash');
    };
    // パスワード表示切替ボタンにクリックイベントを追加
    passwordButtonEye.addEventListener('click', clickPasswordButtonEyeHandler);
  } else {
    console.error('Error: #js-passwordButtonEye or #js-password not found.');
  }

  /**
 * パスワードの強度をチェックし、強度数を返す
 * @param {string} password パスワード文字列
 * @return {number} 強度数（0から4の範囲）
 */
  const checkPasswordStrength = passwordAdminValue => {
    let passwordStrengthNumber = 0;

    // パスワードの長さが8文字以上なら強度数を加算
    if (passwordAdminValue.length >= 8) {
      passwordStrengthNumber++;
      console.log('8文字以上++');
    }

    // 小文字が含まれていれば強度数を加算
    if (/[a-z]/.test(passwordAdminValue)) {
      passwordStrengthNumber++;
      console.log('小文字++');
    }

    // 数字が含まれていれば強度数を加算
    if (/\d/.test(passwordAdminValue)) {
      passwordStrengthNumber++;
      console.log('数字++');
    }

    // 特殊文字が含まれていれば強度数を加算
    if (/[!@#$%^&*()\-_=+[\]{}|;:'",.<>/?`~\\]/.test(passwordAdminValue)) {
      console.log('特殊文字++');
      passwordStrengthNumber++;
    }

    // 各条件が満たされない場合に強度数を0にする
    if (passwordStrengthNumber === 0) {
      console.log('強度0');
    }

    // プログレスバーとサークルの更新
    passwordToggle(passwordStrengthNumber);
    return passwordStrengthNumber;
  };

  /**
   * パスワードの強度を文字列で返す
   * @return {string} パスワードの強度（非常に強い、強い、普通、弱い、非常に弱い）
   */
  const showPasswordStrength = () => {
    let passwordAdminValue = document.querySelector('#js-password-admin').value;
    let passwordStrengthNumber = checkPasswordStrength(passwordAdminValue);
    console.log(`パスワードの強度数${passwordStrengthNumber}`);

    let passwordStrengthText;
    if (passwordStrengthNumber >= 4) {
      passwordStrengthText = "最強";
    } else if (passwordStrengthNumber === 3) {
      passwordStrengthText = "強";
    } else if (passwordStrengthNumber === 2) {
      passwordStrengthText = "普通";
    } else {
      passwordStrengthText = "弱";
    }
    return passwordStrengthText;
  };

  /**
   * サークルのアクティブ状態とプログレスバーの幅を更新する
   * @param {number} currentActive 現在のアクティブなサークルの数
   */
  const passwordToggle = currentActive => {
    circles.forEach((circle, idx) => {
      // サークルにクラス 'js-circle-active' をトグルする
      circle.classList.toggle('js-circle-active', idx < currentActive);
    });
    // プログレスバーの幅を更新する
    passwordProgress.style.width = (currentActive - 1) / (circles.length - 1) * 100 + '%';
  };

  // HTML要素の取得
  const passwordProgress = document.querySelector('.js-passwordProgress');
  const circles = document.querySelectorAll('.js-circle');

  // // 初期のアクティブなサークル数
  let currentActive = 0;

  // パスワードの強度を初期表示する
  const passwordStrength = document.querySelector('#js-password-strength');
  if (passwordStrength) {
    passwordStrength.textContent = `${showPasswordStrength()}`;
    if (passwordStrength.textContent === '最強') {
      passwordStrength.style.color = "red";
    }
  }
  // 入力イベントを監視して、パスワードの強度を動的に更新する

  if (passwordAdmin) {
    passwordAdmin.addEventListener('input', () => {
      passwordStrength.textContent = `${showPasswordStrength()}`;
      if (passwordStrength.textContent === '最強') {
        passwordStrength.style.color = "red";
      }
    });
  }



  /**
   * テーブルの写真をクリック拡大
   */
  const images = document.querySelectorAll('.table_td img');
  const overlay = document.getElementById('js-overlay');
  const overlayImage = document.getElementById('js-overlay-image');
  const closeButton = document.getElementById('js-close-button');

  images.forEach(function (image) {
    image.addEventListener('click', function () {
      overlay.style.display = 'flex'; // オーバーレイを表示
      overlayImage.src = image.src; // クリックした画像を拡大表示
    });
  });

  if (closeButton) {
    closeButton.addEventListener('click', function () {
      overlay.style.display = 'none'; // オーバーレイを非表示
    });
  }

  if (overlay) {
    overlay.addEventListener('click', function (e) {
      if (e.target === overlay) {
        overlay.style.display = 'none'; // オーバーレイの外側をクリックしても非表示にする
      }
    });
  }



  // モーダルメニュー
  const modalOpen = document.querySelector('#js-modal-open');
  const modalClose = document.querySelector('#js-modal-close');
  const modalBg = document.querySelector('#js-modal-bg');
  const modalContainer = document.querySelector('#js-modal-container');

  if (modalOpen) {
    modalOpen.addEventListener('click', () => {
      modalContainer.classList.toggle('active');
      modalBg.classList.toggle('active');
    });
  }

  if (modalClose) {
    modalClose.addEventListener('click', () => {
      modalContainer.classList.toggle('active');
      modalBg.classList.toggle('active');
    });
  }

  if (modalBg) {
    modalBg.addEventListener('click', () => {
      modalContainer.classList.remove('active');
      modalBg.classList.remove('active');
    });
  }


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



/*
ローディングから画面遷移
================================================ */
const loadingAreaGrey = document.querySelector('#loading');
const loadingAreaGreen = document.querySelector('#loading-screen');
const loadingText = document.querySelector('#loading p');

window.addEventListener('load', () => {
  // ローディング中（グレースクリーン）
  loadingAreaGrey.animate(
    {
      opacity: [1, 0],
      visibility: 'hidden',
    },
    {
      duration: 2000,
      delay: 1200,
      easing: 'ease',
      fill: 'forwards',
    }
  );

  // ローディング中（薄緑スクリーン）
  loadingAreaGreen.animate(
    {
      translate: ['0 100vh', '0 0', '0 -100vh']
    },
    {
      duration: 2000,
      delay: 800,
      easing: 'ease',
      fill: 'forwards',
    }
  );

  // ローディング中テキスト
  loadingText.animate(
    [
      {
        opacity: 1,
        offset: .8  //80%
      },
      {
        opacity: 0,
        offset: 1  //100%
      },
    ],
    {
      duration: 1200,
      easing: 'ease',
      fill: 'forwards',
    }
  );
});


/*
スクロールアニメーション
================================================ */
window.addEventListener('scroll', reveal);

function reveal() {
  let reveals = document.querySelectorAll('.reveal');

  for (let i = 0; i < reveals.length; i++) {

    console.log(window.innerHeight);
    let windowheight = window.innerHeight;
    let revealtop = reveals[i].getBoundingClientRect().top;
    let revealpoint = 150;

    if (revealtop < windowheight - revealpoint) {
      reveals[i].classList.add('active');
    } else {
      reveals[i].classList.remove('active');
    }
  }
}


// const heading = document.querySelector('#heading');

// const keyframes = {
//   opacity: [0, 1],
//   rotate: ['x 360deg', 'x 0deg'],
//   translate: ['0 50px', 0],
//   color: ['#f66', '#fc2', '#0c6', '#0bd'],
//   backgroundPosition: ['100% 0', '0 0'],
// };
// // 監視対象が範囲内に現れたら実行する動作
// const showKirin = (entries) => {
//   const keyframes = {
//     opacity: [0, 1],
//     translate: ['200px 0', 0],
//   };
//   console.log('observeの範囲');
//   console.log(entries[0].target);
//   entries[0].target.animate(keyframes, 600);
// };

// // 監視ロボットの設定
// const observe = new IntersectionObserver(showKirin);

// // #kirinを監視するよう指示
// observe.observe(document.querySelector('#observe'));

// const options = {
//   duration: 2000,
//   direction: 'alternate',
//   easing: 'ease',
//   //   iterations: Infinity,
// };
// heading.animate(keyframes, options);

// heading.animate(
//   {
//     filter: [
//       'grayscale(0%)', // 開始値
//       'grayscale(100%)' // 終了値
//     ]
//   },
//   {
//     duration: 500, // ミリ秒指定
//     fill: 'forwards', // 終了時にプロパティーを保つ
//     easing: 'ease' // 加減速種類
//   }
// );

// const items = document.querySelectorAll('.img-item');
// for (let i = 0; i < items.length; i++) {
//   const keyframes = {
//     filter: ['blur(20px)', 'blur(0)'],
//     opacity: [0, 1],
//     rotate: ['5deg', 0],
//     scale: [1.1, 1],
//     translate: ['0 50px', 0],
//   };
//   const options = {
//     duration: 600,
//     delay: i * 300,
//     fill: 'forwards',
//   };
//   items[i].animate(keyframes, options);
// }

// const body = document.body;
// body.addEventListener('wheel', (event) => {
//   // 表示領域の高さ
//   const viewWidth = document.documentElement.clientWidth;
//   console.log(`表示領域の幅：${viewWidth}`)
//   // スクロールを無効
//   if (600 > viewWidth) {
//     event.preventDefault();
//   }
// }, {
//   passive: false
// });


// 写真スライド
const imageTotalNumber = 6,
mainImageElement = document.querySelector("#js-mainImage");
imageListElement = document.querySelector("#js-imageList");
// 矢印
prevImageElement = document.querySelector("#js-prevImage");
nextImageElement = document.querySelector("#js-nextImage");
let currentSlideNumber = 1;

console.log(imageListElement);
// mainImageの中にsrcのimagesをセットする
mainImageElement.setAttribute("src", "../../public/imageProfile/hobby_01.jpg");

const number = document.querySelector("#js-currentSlideNumber");
number.textContent = `${currentSlideNumber} / ${imageTotalNumber}`;

// ドットナビゲーション
for (let i = 0; i < imageTotalNumber; i++) {
  const li = document.createElement("li");
  li.style.backgroundImage = `url(../../public/imageProfile/hobby_0${i + 1}.jpg)`;
  li.addEventListener("click", () => {
    mainImageElement.setAttribute("src", `../../public/imageProfile/hobby_0${i + 1}.jpg`);
    number.textContent = `${i + 1} / ${imageTotalNumber}`;
  })
  imageListElement.appendChild(li);
}

// 左矢印
prevImageElement.addEventListener("click", () => {
  if (currentSlideNumber !== 1) {
    currentSlideNumber--;
    mainImageElement.setAttribute("src", `../../public/imageProfile/hobby_0${currentSlideNumber}.jpg`);
  } else if (currentSlideNumber === 1) {
    currentSlideNumber = 6;
    mainImageElement.setAttribute("src", `../../public/imageProfile/hobby_0${currentSlideNumber}.jpg`);
  }
  number.textContent = `${currentSlideNumber} / ${imageTotalNumber}`;
})

// 右矢印
nextImageElement.addEventListener("click", () => {
  if (currentSlideNumber !== imageTotalNumber) {
    currentSlideNumber++
    mainImageElement.setAttribute("src", `../../public/imageProfile/hobby_0${currentSlideNumber}.jpg`);
  }
  else if (currentSlideNumber === 6) {
    currentSlideNumber = 1;
    mainImageElement.setAttribute("src", `../../public/imageProfile/hobby_0${currentSlideNumber}.jpg`);
  }
  number.textContent = `${currentSlideNumber} / ${imageTotalNumber}`;
})


>>>>>>> feature
