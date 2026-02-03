// Shared JS for Medilink Pharmacy pages
(function () {
    // Utility: get current page filename
    function currentPage() {
        const p = location.pathname.split('/').pop();
        return p || 'index.html';
    }

    // Notifications dropdown
    function initNotifications() {
        const headers = document.querySelectorAll('header');
        headers.forEach(header => {
            if (header.querySelector('#notifBell')) return; // already injected

            const container = document.createElement('div');
            container.style.position = 'relative';
            container.style.display = 'inline-block';
            container.innerHTML = `
                <button id="notifBell" title="Notifications" style="background:none;border:none;cursor:pointer;position:relative;font-size:18px;margin-left:12px;">
                    <i class="fas fa-bell"></i>
                    <span id="notifCount" style="position:absolute;top:-6px;right:-6px;background:#d32f2f;color:white;border-radius:50%;padding:2px 6px;font-size:11px;display:none;">0</span>
                </button>
                <div id="notifDropdown" style="display:none;position:absolute;right:0;top:34px;background:white;border:1px solid #eee;border-radius:8px;box-shadow:0 8px 24px rgba(0,0,0,0.08);width:320px;z-index:999;padding:10px;font-size:14px;">
                    <strong style="display:block;margin-bottom:8px;">Notifications</strong>
                    <div class="notif-item" style="padding:8px;border-radius:6px;">Stock bas sur Paracétamol</div>
                    <div class="notif-item" style="padding:8px;border-radius:6px;">Nouvelle ordonnance reçue</div>
                    <div class="notif-item" style="padding:8px;border-radius:6px;">Expiration prochaine: Amoxicillin</div>
                </div>
            `;

            header.appendChild(container);

            const bell = container.querySelector('#notifBell');
            const dropdown = container.querySelector('#notifDropdown');
            const count = container.querySelector('#notifCount');
            count.innerText = '3'; count.style.display = 'inline-block';

            bell.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdown.style.display = dropdown.style.display === 'flex' || dropdown.style.display === 'block' ? 'none' : 'block';
                dropdown.style.flexDirection = 'column';
            });

            document.addEventListener('click', () => { dropdown.style.display = 'none'; });
        });
    }

    // Sidebar active link based on filename
    function initSidebarActive() {
        const page = currentPage();
        document.querySelectorAll('.sidebar .nav-menu .nav-item').forEach(a => {
            try {
                const href = a.getAttribute('href') || '';
                a.classList.toggle('active', href.endsWith(page));
            } catch (e) { }
        });
    }

    // Global search: behavior depends on page
    function initGlobalSearch() {
        const page = currentPage();

        const headerSearch = document.querySelector('header input[type="text"]') || document.querySelector('.table-header input') || document.querySelector('.search-bar input');
        if (!headerSearch) return;

        headerSearch.addEventListener('input', function (e) {
            const q = e.target.value.trim().toLowerCase();
            if (page === 'pharmacie_inventory') {
                document.querySelectorAll('.data-table tbody tr').forEach(tr => {
                    const name = (tr.querySelector('td strong') && tr.querySelector('td strong').innerText) || '';
                    const sku = (tr.querySelector('td small') && tr.querySelector('td small').innerText) || '';
                    const text = (name + ' ' + sku).toLowerCase();
                    tr.style.display = text.includes(q) ? '' : 'none';
                });
            } else if (page === 'pharmacie_sales') {
                document.querySelectorAll('.product-grid .product-card').forEach(card => {
                    const name = (card.querySelector('strong') && card.querySelector('strong').innerText) || '';
                    const id = (card.querySelector('small') && card.querySelector('small').innerText) || '';
                    const txt = (name + ' ' + id).toLowerCase();
                    card.style.display = txt.includes(q) ? 'block' : 'none';
                });
            } else if (page === 'pharmacie_prescription' || page === 'dashboard_pharmacie') {
                document.querySelectorAll('.prescription-item').forEach(item => {
                    const patient = (item.querySelector('strong') && item.querySelector('strong').innerText) || '';
                    const doctor = (item.querySelector('span') && item.querySelector('span').innerText) || '';
                    const txt = (patient + ' ' + doctor).toLowerCase();
                    item.style.display = txt.includes(q) ? '' : 'none';
                });
            }
        });
    }

    // Prescriptions modal helpers: open/close/confirm
    let lastPrescriptionRow = null;
    function openValidation(patientName, doctorName, row) {
        const modal = document.getElementById('validationModal');
        if (!modal) return;
        document.getElementById('modalPatient').innerText = patientName;
        document.getElementById('modalDoctor').innerText = doctorName;
        modal.style.display = 'flex';
        lastPrescriptionRow = row || null;
    }
    function closeModal() { const modal = document.getElementById('validationModal'); if (modal) modal.style.display = 'none'; }
    function confirmValidation() {
        if (lastPrescriptionRow) {
            const badge = lastPrescriptionRow.querySelector('.badge');
            if (badge) { badge.className = 'badge badge-completed'; badge.innerText = 'Terminé'; }
        }
        alert('Ordonnance validée ! (Simulation)');
        closeModal();
    }

    function bindPrescriptionButtons() {
        document.querySelectorAll('.validate-btn, .btn-reorder.validate-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const row = this.closest('.prescription-item');
                const patient = (row.querySelector('strong') && row.querySelector('strong').innerText) || '';
                const doctor = (row.querySelector('span') && row.querySelector('span').innerText) || '';
                openValidation(patient, doctor, row);
            });
        });
        const confirmBtn = document.querySelector('#validationModal button[onclick*="confirmValidation"]');
        if (confirmBtn) confirmBtn.addEventListener('click', confirmValidation);
        const closeBtns = document.querySelectorAll('#validationModal button[onclick*="closeModal"], #validationModal .close');
        closeBtns.forEach(b => b.addEventListener('click', closeModal));
    }

    // Init sequence
    document.addEventListener('DOMContentLoaded', () => {
        initNotifications();
        initSidebarActive();
        initGlobalSearch();
        bindPrescriptionButtons();
        window.medilink = window.medilink || {};
        window.medilink.openValidation = openValidation;
        window.medilink.confirmValidation = confirmValidation;
    });

})();
