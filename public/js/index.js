// DOMの読み込み完了後に処理を開始
document.addEventListener("DOMContentLoaded", () => {

  //** ============ form ==================*/
  // フォームの送信処理
  const form = document.querySelector('form');
  if (form) {
    form.addEventListener('submit', (e) => {
      // e.preventDefault();
      console.log(form.elements.text.value);
    });
  }

  //** ============ バリデーションチェック ==================*/
  // 電話番号フィールドのバリデーションとメッセージの設定
  const tel = document.querySelector('#js-tel');
  const telMessage = document.querySelector('#js-telMessage');
  if (tel) {
    const validateTel = (e) => {
      console.log(e.target.value);
      const telValue = e.target.value;
      // 入力が空白または許可されている文字以外を含んでいるかをチェック
      if (!telValue.trim()) {
        telMessage.innerText = '電話番号を入力してください';
        tel.style.border = '2px solid red';
      } else if (!/^[0-9+\-]+$/.test(telValue)) {
        telMessage.innerText = '半角数字と + - のみ利用できます';
      } else if (!/^(0\d{9,10}|\d{1,4}-\d{1,4}-\d{4})$/.test(telValue)) {
        telMessage.innerText = '正しい電話番号の形式で入力してください';
      } else {
        telMessage.innerText = '';
        tel.style.border = '';
      }
    }
    // フォーカスアウト時にバリデーションを実行
    tel.addEventListener('blur', validateTel);
  }

  //** ============ ラジオボタン ==================*/
  // ラジオボタンの選択状態監視
  const radio = document.querySelector('#js-radio');
  if (radio) {
    const radioChange = (event) => {
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
  }

  //** ============ セレクト ==================*/
  // セレクトボックスの選択状態監視
  const select = document.querySelector('#js-select');
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
  // チェックボックスの選択状態監視
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
  // テキストエリアの文字数カウント
  const textarea = document.querySelector('#js-textarea');
  const textareaCount = document.querySelector('#js-textareaCount');

  if (textarea && textareaCount) {
    textareaCount.innerText = textarea.value.length;
    const textareaInput = () => {
      const textareaValue = textarea.value;
      textareaCount.innerText = textareaValue.length;
    }
    textarea.addEventListener('input', textareaInput);
  } else {
    console.error('Error: #js-textarea not found.');
  }

  //** ============ カレンダー ==================*/
  // カレンダーの選択日時のログ出力
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
  // 利用規約に同意した場合の送信ボタンの操作
  const check = document.querySelector('#js-check');
  const $submit = document.querySelector('#js-submit');

  if ($submit) {
    $submit.style.opacity = '60%';
  }

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
      } else {
        $submit.style.opacity = '100%';
        $submit.style.cursor = 'pointer';
      }
    }
    check.addEventListener('change', checkChange);
  }

  //** ============ ファイル ==================*/
  // ファイルの選択とプレビュー表示
  const image = document.querySelector('#js-image');
  const imagePreview = document.querySelector('#js-imagePreview');

  if (image && imagePreview) {
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

  //** ============ チェックボックス（user_top.php） ==================*/
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

  //** ============ 削除（admin_top.php） ==================*/
  // 削除ボタンの確認ダイアログ表示
  const btnDelete = document.querySelectorAll('.js-btndelete');
  if (btnDelete) {
    btnDelete.forEach((btnDelete) => {
      btnDelete.addEventListener('click', (e) => {
        const result = confirm('削除しますか');
        if (!result) {
          e.preventDefault();
        }
      })
    })
  }

  //** ============ パスワードアイコンクリック（admin_signup.php） ==================*/
  const passwordField = document.querySelector('#js-password');
  const passwordButtonEye = document.querySelector('#js-passwordButtonEye');
  if (passwordButtonEye && passwordField) {
    // パスワード表示切替処理
    const togglePassword = () => {
      // パスワードフィールドのタイプをトグル（テキスト ⇄ パスワード）
      passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
      // パスワード表示切替アイコンのクラスをトグル（目のアイコン ⇄ 斜線のアイコン）
      passwordButtonEye.classList.toggle('fa-eye-slash');
    };
    // パスワード表示切替ボタンにクリックイベントを追加
    passwordButtonEye.addEventListener('click', togglePassword);
  } else {
    console.error('Error: #js-passwordButtonEye or #js-password not found.');
  }



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
