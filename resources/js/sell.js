document.addEventListener('DOMContentLoaded', function () {

    // ===============================
    // カテゴリ選択ロジック
    // ===============================
    const categories = window.categoryData || [];

    const parentSelect = document.querySelector('.js-parent-category');
    const childSelect = document.querySelector('.js-child-category');
    const grandSelect = document.querySelector('.js-grand-category');
    const finalInput = document.querySelector('.js-final-category');
    const displayArea = document.querySelector('.js-category-display');
    const config = document.querySelector('.js-category-config');

    if (parentSelect) {
        /**
         * 選択されたカテゴリIDをhiddenに反映し、バッジを更新する
         */
        function updateSelectedCategory(selectElement) {
            if (selectElement && selectElement.value !== '') {
                finalInput.value = selectElement.value;
                updateBadge(selectElement.options[selectElement.selectedIndex].text);
            } else {
                // 何も選択されていない場合はリセット（ただし、親が選択されていればその値を維持したい場合は調整が必要）
                // 今回は「最後に変更があったセレクトボックスの値」を正とする
            }
        }

        /**
         * 下位カテゴリのオプションを生成する
         */
        function renderOptions(selectElement, parentId, placeholder) {
            selectElement.innerHTML = '';

            const filtered = categories.filter(function (category) {
                return category.parent_id == parentId;
            });

            if (filtered.length === 0) {
                selectElement.classList.add('is-hidden');
                return false;
            }

            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = placeholder;
            selectElement.appendChild(defaultOption);

            filtered.forEach(function (category) {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.content;
                selectElement.appendChild(option);
            });

            selectElement.classList.remove('is-hidden');
            return true;
        }

        /**
         * 画面上のカテゴリバッジを更新する
         */
        function updateBadge(text) {
            displayArea.innerHTML = '';
            if (!text) return;

            const badge = document.createElement('span');
            badge.className = 'category-badge';
            badge.textContent = text;
            displayArea.appendChild(badge);
        }

        // --- イベントリスナー ---
        parentSelect.addEventListener('change', function () {
            renderOptions(childSelect, this.value, '中カテゴリを選択');
            grandSelect.classList.add('is-hidden');
            grandSelect.innerHTML = '';
            finalInput.value = this.value; // 大カテゴリのIDを一旦セット
            updateBadge(this.value ? this.options[this.selectedIndex].text : '');
        });

        childSelect.addEventListener('change', function () {
            const hasGrandChild = renderOptions(grandSelect, this.value, '小カテゴリを選択');
            if (this.value !== '') {
                finalInput.value = this.value; // 中カテゴリのIDで上書き
                updateBadge(this.options[this.selectedIndex].text);
            } else {
                // 中カテゴリが未選択に戻ったら大カテゴリの値に戻す
                finalInput.value = parentSelect.value;
                updateBadge(parentSelect.options[parentSelect.selectedIndex].text);
            }
        });

        grandSelect.addEventListener('change', function () {
            if (this.value !== '') {
                finalInput.value = this.value; // 小カテゴリのIDで上書き
                updateBadge(this.options[this.selectedIndex].text);
            } else {
                // 小カテゴリが未選択に戻ったら中カテゴリの値に戻す
                finalInput.value = childSelect.value;
                updateBadge(childSelect.options[childSelect.selectedIndex].text);
            }
        });

        // --- バリデーションエラー後の復元処理 ---
        const oldId = config ? config.dataset.oldId : null;
        if (oldId) {
            const selectedCat = categories.find(c => c.id == oldId);
            if (selectedCat) {
                // 親子関係を遡って特定する（実務では再帰や階層データを使いますが、ここではシンプルに実装）
                const parentId = selectedCat.parent_id;

                if (parentId) {
                    const parentCat = categories.find(c => c.id == parentId);
                    if (parentCat && parentCat.parent_id) {
                        // 孫カテゴリ（小カテゴリ）の場合
                        parentSelect.value = parentCat.parent_id;
                        parentSelect.dispatchEvent(new Event('change'));
                        childSelect.value = parentId;
                        childSelect.dispatchEvent(new Event('change'));
                        grandSelect.value = oldId;
                        updateBadge(grandSelect.options[grandSelect.selectedIndex].text);
                    } else {
                        // 子カテゴリ（中カテゴリ）の場合
                        parentSelect.value = parentId;
                        parentSelect.dispatchEvent(new Event('change'));
                        childSelect.value = oldId;
                        updateBadge(childSelect.options[childSelect.selectedIndex].text);
                    }
                } else {
                    // 親カテゴリの場合
                    parentSelect.value = oldId;
                    parentSelect.dispatchEvent(new Event('change'));
                }
            }
        }
    }

    // ===============================
    // 画像プレビュー
    // ===============================
    const imageInput = document.querySelector('.js-image-input');
    const previewContainer = document.querySelector('#js-preview-container'); // エリアを特定

    if (imageInput) {
        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                previewContainer.innerHTML = '';
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'sell-image-preview';
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }
});