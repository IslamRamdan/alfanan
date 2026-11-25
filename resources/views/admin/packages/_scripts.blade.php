<script>
    document.getElementById('add-feature').addEventListener('click', function() {
        const wrapper = document.getElementById('features-wrapper');
        const row = document.createElement('div');
        row.className = 'row mb-2 feature-row align-items-center';
        row.innerHTML = `
            <div class="col-md-6">
                <input type="text" name="features[]" class="form-control" placeholder="ميزة الباقة (عربي)..." required>
            </div>
            <div class="col-md-5">
                <input type="text" name="features_en[]" class="form-control" placeholder="Package feature (English - اختياري)">
            </div>
            <div class="col-md-1 text-center">
                <button type="button" class="btn btn-danger btn-sm remove-feature">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        wrapper.appendChild(row);
    });

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.remove-feature');
        if (btn) {
            const rows = document.querySelectorAll('.feature-row');
            if (rows.length > 1) {
                btn.closest('.feature-row').remove();
            } else {
                alert('يجب أن تحتوي الباقة على ميزة واحدة على الأقل.');
            }
        }
    });
</script>
