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
    const radioChange = (event) => {
      const target = event.target;
      if (target.name === 'gender') {
        const genderValue = target.value;
        console.log(`選択された性別は ${genderValue} です`);
      } else if (target.name === 'drink') {
        const drinkValue = target.value;
        console.log(`選択された飲み物は ${drinkValue} です`);
      }
    }
    radio.addEventListener('change', radioChange);
  }

  // セレクトボックスの選択状態監視
  const select = document.querySelector('#js-select');
  if (select) {
    /**
     * セレクトボックスの選択状態が変化した際に、選択された値をコンソールに出力します。
     * @param {Event} event 変更イベント
     */
    const selectChange = (event) => {
      console.log(`セレクトのvalue値は ${select.value} です`);
      const selectOptions = select.options[select.selectedIndex].innerHTML;
      console.log(`セレクトの中身は ${selectOptions} です`);
    }
    select.addEventListener('change', selectChange);
  }

  // チェックボックスの選択状態監視
  const checkboxes = document.querySelectorAll('#js-checkbox input[type="checkbox"]');
  if (checkboxes) {
    /**
     * チェックボックスの選択状態が変化した際に、選択された値をコンソールに出力します。
     */
    const checkboxChange = () => {
      let checkbox_output = '';
      checkboxes.forEach((checkbox) => {
        if (checkbox.checked) {
          checkbox_output += ' ' + checkbox.value;
        }
      });
      console.log(`選択されたチェックボックス: ${checkbox_output}`);
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
      checkbox.addEventListener('change', checkboxChange);
    });
  }

  // テキストエリアの文字数カウント
  const textarea = document.querySelector('#js-textarea');
  const textareaCount = document.querySelector('#js-textareaCount');
  if (textarea && textareaCount) {
    /**
     * テキストエリアの入力内容が変化した際に、文字数をカウントして表示します。
     */
    const textareaInput = () => {
      const textareaValue = textarea.value;
      textareaCount.innerText = textareaValue.length;
    }
    textarea.addEventListener('input', textareaInput);
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
    const checkChange = (event) => {
      const checked = event.target.checked;
      submitButton.disabled = !checked;
      submitButton.style.opacity = checked ? '100%' : '60%';
      submitButton.style.cursor = checked ? 'pointer' : 'default';
    }
    check.addEventListener('change', checkChange);
  }

  // ファイルの選択とプレビュー表示
  const image = document.querySelector('#js-image');
  const imagePreview = document.querySelector('#js-imagePreview');
  if (image && imagePreview) {
    /**
    * ファイルが選択された時に、画像ファイルであればプレビュー表示を行います。
    * @param {Event} event 変更イベント
    */
    const imageChange = (event) => {
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
        const imagePathError = document.querySelector('.image_path_error');
        if (imagePathError.innerText !== '') {
          imagePathError.innerText = '';
        }
      });
      // ファイル読み込み開始
      reader.readAsDataURL(file);
    };

    // 変更時に画像をプレビュー
    image.addEventListener('change', imageChange);
  }

  // 変更時にフォームを送信
  const selectImageGallery = document.querySelector('#js-select-image-gallery');
  const selectImageGalleryForm = document.querySelector('#js-select-image-gallery-form');
  if (selectImageGallery) {
    const selectImageGalleryChange = (event) => {
      selectImageGalleryForm.submit();
      console.log(parseInt(event.target.value));
    }
    selectImageGallery.addEventListener('change', selectImageGalleryChange);
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
    const togglePassword = () => {
      // パスワードフィールドのタイプをトグル（テキスト ⇄ パスワード）
      passwordAdmin.type = passwordAdmin.type === 'password' ? 'text' : 'password';
      // パスワード表示切替アイコンのクラスをトグル（目のアイコン ⇄ 斜線のアイコン）
      passwordButtonEye.classList.toggle('fa-eye-slash');
    };
    // パスワード表示切替ボタンにクリックイベントを追加
    passwordButtonEye.addEventListener('click', togglePassword);
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
      passwordStrengthText = "非常に強い";
    } else if (passwordStrengthNumber === 3) {
      passwordStrengthText = "強い";
    } else if (passwordStrengthNumber === 2) {
      passwordStrengthText = "普通";
    } else {
      passwordStrengthText = "弱い";
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
    passwordStrength.textContent = `パスワードの強度:${showPasswordStrength()}`;
  }
  // 入力イベントを監視して、パスワードの強度を動的に更新する

  if (passwordAdmin) {
    passwordAdmin.addEventListener('input', () => {
      passwordStrength.textContent = `パスワードの強度:${showPasswordStrength()}`;
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

  closeButton.addEventListener('click', function () {
    overlay.style.display = 'none'; // オーバーレイを非表示
  });

  overlay.addEventListener('click', function (e) {
    if (e.target === overlay) {
      overlay.style.display = 'none'; // オーバーレイの外側をクリックしても非表示にする
    }
  });



  // モーダルメニュー
  const open = document.querySelector('#modal-open');
  const container = document.querySelector('#modal-container');
  const modalBg = document.querySelector('#modal-bg');
  const close = document.querySelector('#modal-close');

  open.addEventListener('click', () => {
    container.classList.toggle('active');
    modalBg.classList.toggle('active');
  });

  close.addEventListener('click', () => {
    container.classList.toggle('active');
    modalBg.classList.toggle('active');
  });

  modalBg.addEventListener('click', () => {
    container.classList.remove('active');
    modalBg.classList.remove('active');
  });



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
