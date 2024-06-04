<!-- Bootstrap CSS v5.2.1 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Sans+TC:wght@100..900&display=swap" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- css -->
<style>
    /* 變數 */
    :root {
        --primary-color: #e3dcd3;
        --secondary-color: #9ba45c;
        --shadow-color: #9a968f;
        --highlight-color: #ffffff;
        --font-color: #2d2d2d;
        --input-padding: 10px;
        --border-radius: 36px;
    }

    body {
        font-family: "Montserrat", "Noto Sans TC";
        background: var(--primary-color);
        color: var(--font-color);
    }

    /* 表單 */
    .input-group-neumorphic {
        display: flex;
        align-items: center;
    }

    .form-control-neumorphic {
        background: var(--primary-color);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: inset 5px 5px 10px var(--shadow-color), inset -5px -5px 10px var(--highlight-color);
        font-size: 16px;
        padding: var(--input-padding);
        padding-left: 15px;
        padding-right: 15px;
        margin-right: 10px;
        transition: all 0.3s ease;
        flex: 1;
    }

    .form-control-neumorphic:focus {
        outline: none;
        box-shadow: inset 5px 5px 15px var(--shadow-color), inset -5px -5px 15px var(--highlight-color);
    }

    /* 按鈕 */
    .btn-neumorphic {
        color: var(--secondary-color);
        background: var(--primary-color);
        border: 1px solid transparent;
        border-radius: var(--border-radius);
        box-shadow: 5px 5px 10px var(--shadow-color), -5px -5px 10px var(--highlight-color);
        font-size: 16px;
        padding: var(--input-padding);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-neumorphic:hover,
    .btn-neumorphic:focus {
        color: var(--secondary-color);
        outline: none;
        border: 1px solid var(--highlight-color);
        box-shadow: 5px 5px 15px var(--shadow-color), -5px -5px 15px var(--highlight-color);
    }

    .btn-neumorphic:active {
        color: var(--secondary-color) !important;
        outline: none;
        border: 1px solid var(--highlight-color);
        box-shadow: inset 5px 5px 10px var(--shadow-color), inset -5px -5px 10px var(--highlight-color);
    }

    .btn-circle {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* 表格 */
    .table-wrapper {
        border-radius: 24px;
        overflow: auto;
        box-shadow: 6px 6px 12px var(--shadow-color), -6px -6px 12px var(--highlight-color);
    }

    .neumorphic-table {
        table-layout: fixed;
    }

    .neumorphic-table th,
    .neumorphic-table td {
        border: none;
        word-wrap: break-word;
        padding: 12px;
        text-align: center;
        vertical-align: middle;
    }

    .neumorphic-table th {
        border-bottom: 1px solid var(--secondary-color);
        color: var(--secondary-color);
        font-size: 12px;
        letter-spacing: 1px;
        background: var(--primary-color);
    }

    .neumorphic-table td {
        color: var(--font-color);
        font-size: 15px;
        background: var(--primary-color);
    }

    /* 分頁按鈕 */
    .pagination .page-item .page-link {
        background: var(--primary-color);
        border: none;
        border-radius: 50%;
        box-shadow: 5px 5px 10px var(--shadow-color), -5px -5px 10px var(--highlight-color);
        font-size: 16px;
        color: var(--secondary-color);
        width: 42px;
        height: 42px;
        padding: var(--input-padding);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 30px 5px;
    }

    .pagination .page-item.active .page-link {
        box-shadow: inset 5px 5px 10px var(--shadow-color), inset -5px -5px 10px var(--highlight-color);
    }

    .pagination .page-item .page-link:hover,
    .pagination .page-item .page-link:focus {
        outline: none;
        box-shadow: inset 5px 5px 10px var(--shadow-color), inset -5px -5px 10px var(--highlight-color);
    }

    /* 日期 */
    .flatpickr-calendar {
        background: var(--primary-color);
        border: none;
        border-radius: 24px;
        box-shadow: 5px 5px 10px var(--shadow-color), -5px -5px 10px var(--highlight-color);
    }

    .flatpickr-day {
        font-size: 12px;
        border-radius: var(--border-radius);
        transition: all 0.3s ease;
    }

    .flatpickr-day:hover {
        background: var(--highlight-color);
        box-shadow: 5px 5px 10px var(--shadow-color), -5px -5px 10px var(--highlight-color);
    }

    .flatpickr-day.selected {
        color: var(--font-color);
        background: var(--highlight-color);
        box-shadow: inset 5px 5px 10px var(--shadow-color), inset -5px -5px 10px var(--highlight-color);
    }

    /* Modal樣式 */
    .coupon-modal .modal-content {
        background: var(--primary-color);
        border-radius: var(--border-radius);
        padding: 20px;
    }

    .coupon-modal .modal-header,
    .coupon-modal .modal-footer {
        color: var(--secondary-color);
        border: none;
        outline: none;
    }

    .coupon-modal .modal-title {
        font-size: 20px;
        font-weight: 600;
    }

    .coupon-modal .table-bordered th,
    .coupon-modal .table-bordered td {
        outline: none;
        border: none;
        vertical-align: middle;
        padding: 10px 0;
    }

    .coupon-modal .table-bordered th {
        background: var(--primary-color);
        color: var(--secondary-color);
        font-weight: 500;
    }

    .coupon-modal .table-bordered td {
        background: var(--primary-color);
        color: var(--font-color);
    }

    .coupon-modal .form-control,
    .coupon-modal .form-select {
        background: var(--primary-color);
        border: none;
        outline: none;
        border-radius: var(--border-radius);
        box-shadow: inset 5px 5px 10px var(--shadow-color), inset -5px -5px 10px var(--highlight-color);
        transition: all 0.3s ease;
    }

    .coupon-modal .form-control:focus,
    .coupon-modal .form-select:focus {
        border: none;
        outline: none;
        box-shadow: inset 5px 5px 15px var(--shadow-color), inset -5px -5px 15px var(--highlight-color);
    }
</style>