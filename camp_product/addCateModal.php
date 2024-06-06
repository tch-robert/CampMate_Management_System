<!-- Modal -->
<div class="modal fade" id="addCateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">新增分類</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="./doAddCategory.php" method="post">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <select class="form-select" name="parent_name" id="" required>
                            <option value="" selected disabled>選擇要新增到哪個類別中</option>
                            <?php foreach ($L1Rows as $level1) : ?>
                                <option value="<?= $level1['category_name'] ?>">
                                    <?= $level1['category_name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input-group">
                        <div class="input-group-text" for="">分類名稱</div>
                        <input class="form-control" type="text" name="category_name" placeholder="輸入分類名稱" required>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-primary">確認新增</button>
                </div>
            </form>
        </div>
    </div>
</div>