
<div class="sidebar p-3" style="width: 280px;">
    <a href="campground_list.php" class="d-flex align-items-center pb-3 mb-3 link-body-emphasis text-decoration-none border-bottom">
    <svg class="bi pe-none me-2" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
    <span class="fs-5 fw-semibold">CAMPMATE</span>
    </a>
    <div class="d-flex justify-content-center mb-5">
        <h7>Hi~ <?=$rowOwner["name"]?></h7>
    </div>
    <ul class="list-unstyled ps-0">
    <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
        個人營地管理
        </button>
        <div class="collapse show" id="home-collapse" >
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="campground_list.php" class="link-body-emphasis d-inline-flex text-decoration-none rounded">營地列表</a></li>
            <li><a href="camp_area_search.php" class="link-body-emphasis d-inline-flex text-decoration-none rounded">營區列表</a></li>
            <li><a href="owner-data.php" class="link-body-emphasis d-inline-flex text-decoration-none rounded">個人資料修改</a></li>
        </ul>
        </div>
    </li>
    <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
        訂單管理
        </button>
        <div class="collapse" id="dashboard-collapse" style="">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">自家訂單</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">營地主訂單</a></li>
        </ul>
        </div>
    </li>
    </ul>
    
</div>