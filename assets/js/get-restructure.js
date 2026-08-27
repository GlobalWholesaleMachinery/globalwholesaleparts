/* =============================================================================
   get-restructure.js
   Motor Grader -> Ground Engaging Tools corrected flow (Steps 3-8).
   Ported from the approved prototype:
   UMAIR_TESTING/MOCKUPS/ground-engaging-tools-real-page-with-corrected-flow.html
   -- rewritten to read data-driven content from window.GWP_GET_DATA (server-
   rendered from the get_attachments / get_wear_components tables) instead of
   the prototype's hardcoded arrays, and cleaned of the prototype's known
   double-init bug (single DOMContentLoaded listener only, see
   docs/get-restructure/03-prototype-spec.md intro note).

   Client decision 2026-08-27: the Rear/Multi-Shank Ripper branch is a FLAT
   grid of GET cards, same as every other attachment -- there is no separate
   shank->tip->pin dependency chain in this build.
   ============================================================================= */
(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    var root = document.getElementById('gwp-get-restructure-root');
    if (!root || !window.GWP_GET_DATA) return; // graceful no-op if data/markup absent

    var CDN = root.getAttribute('data-cdn') || '';
    var DATA = window.GWP_GET_DATA; // array of attachments, each with .wear_components[]

    var attachSection = document.getElementById('gwp-attach-section');
    var getSection = document.getElementById('gwp-get-section');
    var specSection = document.getElementById('gwp-spec-section');
    var hwSection = document.getElementById('gwp-hw-section');
    var qtySection = document.getElementById('gwp-qty-section');
    var reviewSection = document.getElementById('gwp-review-section');

    var HW_OPTIONS = [
      'Complete Hardware Kit',
      'Individual Hardware',
      'No Hardware Required',
      'Reusing Existing'
    ];

    var state = { attachment: null, wearComponents: [], spec: {}, hardware: null, qty: '1' };

    // ---- helpers ---------------------------------------------------------
    function el(tag, attrs, html) {
      var e = document.createElement(tag);
      if (attrs) {
        Object.keys(attrs).forEach(function (k) { e.setAttribute(k, attrs[k]); });
      }
      if (html !== undefined) e.innerHTML = html;
      return e;
    }

    function cardImage(item) {
      if (item.image_path && item.is_illustrative !== 'y') {
        return '<img src="' + CDN + 'assets/images/' + item.image_path + '" class="img-fluid mb-2">';
      }
      // Illustrative / missing photo -- honest placeholder, never substitute a
      // web-sourced or OEM photo (active trademark cease-and-desist, see
      // caterpillar-cease-and-desist project memory).
      return '<div class="get-photo-flag">ILLUSTRATIVE</div>' +
        '<div style="width:100%;height:70px;display:flex;align-items:center;justify-content:center;' +
        'background:#f4f7fa;border:1px dashed #c9d3dd;border-radius:4px;color:#8a97a5;font-size:11px;' +
        'margin-bottom:8px;">Photo pending</div>';
    }

    function titleBar(text, badgeText, badgeClass) {
      var h = el('div', { class: 'get-step-title' });
      h.appendChild(document.createTextNode(text));
      if (badgeText) {
        var b = el('span', { class: 'get-badge' + (badgeClass ? ' ' + badgeClass : '') }, badgeText);
        h.appendChild(b);
      }
      return h;
    }

    function resetFrom(fromKey) {
      var order = ['get', 'spec', 'hw', 'qty', 'review'];
      var idx = order.indexOf(fromKey);
      if (idx === -1) return;
      var sections = { get: getSection, spec: specSection, hw: hwSection, qty: qtySection, review: reviewSection };
      order.slice(idx).forEach(function (k) {
        var s = sections[k];
        if (s) s.innerHTML = '';
      });
    }

    // ---- Step 3: attachment cards -----------------------------------------
    function renderAttachments() {
      var wrap = el('div');
      wrap.appendChild(titleBar('Step 3 — Select the Attachment'));
      wrap.appendChild(el('div', { class: 'get-callout' },
        '👆 Click a card below to select it — the applicable Ground Engaging Tools will appear underneath.'));
      var grid = el('div', { class: 'get-card-grid' });
      DATA.forEach(function (att) {
        var col = el('div');
        var card = el('div', { class: 'btn btn-light custom-checkboxes custom-checkboxes-main w-100' });
        var input = el('input', {
          class: 'custom-checks', type: 'checkbox', style: 'width:14px;',
          id: 'gwp-att-' + att.slug, value: att.slug
        });
        var label = el('label', { class: 'custom-checks-label', for: 'gwp-att-' + att.slug },
          cardImage(att) + att.label);
        card.appendChild(input);
        card.appendChild(label);
        col.appendChild(card);
        grid.appendChild(col);

        input.addEventListener('change', function () {
          if (this.checked) {
            // enforce single-select: uncheck sibling attachment cards
            grid.querySelectorAll('input[type=checkbox]').forEach(function (other) {
              if (other !== input) other.checked = false;
            });
            state.attachment = att;
            resetFrom('get');
            renderGet(att);
          } else {
            state.attachment = null;
            resetFrom('get');
          }
        });
      });
      wrap.appendChild(grid);
      attachSection.innerHTML = '';
      attachSection.appendChild(wrap);
    }

    // ---- Step 4: GET / wear-component cards (flat grid, all attachments) -
    function renderGet(att) {
      var items = att.wear_components || [];
      var wrap = el('div');
      wrap.appendChild(titleBar('Step 4 — Select GET / Wear Component(s)', 'FILTERED BY ATTACHMENT'));
      if (!items.length) {
        wrap.appendChild(el('div', { class: 'get-callout get-callout-amber' },
          'No compatible parts are configured for this attachment yet — contact a Parts Manager for assistance.'));
        getSection.innerHTML = '';
        getSection.appendChild(wrap);
        return;
      }
      var grid = el('div', { class: 'get-card-grid' });
      state.wearComponents = [];
      items.forEach(function (item) {
        var col = el('div');
        var card = el('div', { class: 'btn btn-light custom-checkboxes custom-checkboxes-main w-100' });
        var input = el('input', {
          class: 'custom-checks', type: 'checkbox', style: 'width:14px;',
          id: 'gwp-get-' + item.slug, value: item.slug
        });
        var label = el('label', { class: 'custom-checks-label', for: 'gwp-get-' + item.slug },
          cardImage(item) + item.label);
        card.appendChild(input);
        card.appendChild(label);
        col.appendChild(card);
        grid.appendChild(col);

        input.addEventListener('change', function () {
          if (this.checked) {
            state.wearComponents.push(item);
          } else {
            state.wearComponents = state.wearComponents.filter(function (w) { return w.slug !== item.slug; });
          }
          resetFrom('spec');
          if (state.wearComponents.length) renderSpec(att);
        });
      });
      wrap.appendChild(grid);
      getSection.innerHTML = '';
      getSection.appendChild(wrap);
    }

    // ---- Step 5: specification fields (universal field set) --------------
    function renderSpec(att) {
      var wrap = el('div');
      wrap.appendChild(titleBar('Step 5 — Specification / Part Detail'));
      var row = el('div', { class: 'get-field-row' });

      function field(key, labelText, placeholder) {
        var f = el('div', { class: 'get-field' });
        f.appendChild(el('label', {}, labelText));
        var input = el('input', { class: 'get-input', type: 'text', placeholder: placeholder || '' });
        input.addEventListener('input', function () { state.spec[key] = input.value; });
        f.appendChild(input);
        row.appendChild(f);
        return input;
      }

      field('partType', 'Edge / Part Type', 'e.g. straight, serrated, curved');
      field('dimensions', 'Dimensions (L x W x T)', 'e.g. 72 x 6 x 5/8 in');
      field('mounting', 'Bolt Hole Pattern / Mounting', 'e.g. 10-hole, oval');
      wrap.appendChild(row);

      var row2 = el('div', { class: 'get-field-row' });
      var serialInput = field.call(this, 'machine', 'Machine Make / Model / Serial (optional)', 'optional — helps verify fitment');
      wrap.appendChild(row2);

      var btn = el('button', { type: 'button', class: 'primary-btn' }, 'Confirm Specification →');
      btn.style.marginTop = '4px';
      btn.addEventListener('click', function () {
        state.serialGiven = !!(state.spec.machine && state.spec.machine.trim());
        resetFrom('hw');
        renderHardware(att);
      });
      wrap.appendChild(btn);

      specSection.innerHTML = '';
      specSection.appendChild(wrap);
    }

    // ---- Step 6: installation hardware (static list, per Open Question 2) -
    function renderHardware(att) {
      var wrap = el('div');
      wrap.appendChild(titleBar('Step 6 — Installation Hardware', 'MANDATORY'));
      wrap.appendChild(el('div', { class: 'get-callout' },
        'Bolts, nuts, washers/retainers matched to the selected GET item(s).'));
      HW_OPTIONS.forEach(function (opt, i) {
        var card = el('div', { class: 'btn btn-light custom-checkboxes custom-checkboxes-main w-100 get-hw-option' });
        var input = el('input', { type: 'radio', name: 'gwp_hw', id: 'gwp-hw-' + i, value: opt });
        var label = el('label', { for: 'gwp-hw-' + i }, opt);
        card.appendChild(input);
        card.appendChild(label);
        wrap.appendChild(card);
        input.addEventListener('change', function () {
          state.hardware = opt;
          resetFrom('qty');
          renderQty(att);
        });
      });
      hwSection.innerHTML = '';
      hwSection.appendChild(wrap);
    }

    // ---- Step 7: quantity + fitment verification --------------------------
    function renderQty(att) {
      var wrap = el('div');
      wrap.appendChild(titleBar('Step 7 — Confirm Quantity & Compatibility'));
      var msg = state.serialGiven
        ? '⚠ Fitment Requires Verification — a Parts Manager will confirm exact compatibility against the machine details you provided before this order is finalized.'
        : '⚠ Fitment Requires Verification — no machine serial was provided; a Parts Manager will verify compatibility before this order is finalized.';
      wrap.appendChild(el('div', { class: 'get-verify' }, msg));

      var f = el('div', { class: 'get-field', style: 'max-width:160px;' });
      f.appendChild(el('label', {}, 'Quantity'));
      var qtyInput = el('input', { class: 'get-input', type: 'text', value: '1' });
      qtyInput.addEventListener('input', function () { state.qty = qtyInput.value; });
      f.appendChild(qtyInput);
      wrap.appendChild(f);

      var btn = el('button', { type: 'button', class: 'primary-btn' }, 'Confirm & Continue to Quote →');
      btn.style.marginTop = '10px';
      btn.addEventListener('click', function () {
        resetFrom('review');
        renderReview(att);
      });
      wrap.appendChild(btn);

      qtySection.innerHTML = '';
      qtySection.appendChild(wrap);
    }

    // ---- Step 8: review + best-effort auto-fill of a nearby quote form ----
    function renderReview(att) {
      var wrap = el('div');
      wrap.appendChild(titleBar('Step 8 — Review', 'Feeds the Get a Quote form below'));

      var getLabel = state.wearComponents.map(function (w) { return w.label; }).join(', ');
      var table = el('table', { class: 'get-review-table' });
      [
        ['Machine', 'Motor Grader'],
        ['Attachment', att.label],
        ['GET Component(s)', getLabel || '—'],
        ['Quantity', state.qty || '1'],
        ['Installation Hardware', state.hardware || '—']
      ].forEach(function (pair) {
        var tr = el('tr');
        tr.appendChild(el('td', {}, pair[0]));
        tr.appendChild(el('td', {}, pair[1]));
        table.appendChild(tr);
      });
      wrap.appendChild(table);
      wrap.appendChild(el('div', { class: 'get-callout' },
        'Scroll down to the "Get a Quote" form below to submit this request.'));

      reviewSection.innerHTML = '';
      reviewSection.appendChild(wrap);

      // Best-effort auto-fill (FR-06): look for the nearest quote-request
      // description field to this component in the DOM, rather than a
      // sitewide id/class selector -- see docs/get-restructure/06-implementation-plan.md
      // §2.3 for why a global selector on this shared, multi-instance widget
      // was intentionally NOT used here.
      var summary = 'Motor Grader — ' + att.label + ' — ' + (getLabel || 'n/a') +
        ' — Qty: ' + (state.qty || '1') + ' — Hardware: ' + (state.hardware || 'n/a');
      var scope = root.closest('.landing-page-filter-data-section') || root.parentElement;
      var descField = scope && scope.parentElement
        ? scope.parentElement.querySelector('textarea[name="parts_description"]')
        : null;
      if (descField && !descField.value) {
        descField.value = summary;
      }
    }

    renderAttachments();
  });
})();
