<?php
function pagination($page, $total_pages, $base_url, $total_rows, $end_row, $current_table)
{
  ob_start();

  // Parse URL untuk mendapatkan parameter yang ada
  $url_components = parse_url($base_url);
  parse_str($url_components['query'], $params); // Mendapatkan query string ke array
  $params['table'] = $current_table; // Menambahkan parameter baru

?>
  <section class="mt-2 py-2 flex justify-between items-center">
    <p class="text-slate-600 text-sm">Showing : <?= $end_row ?> of <?= $total_rows; ?> rows</p>
    <p class="text-slate-600 text-sm">Page <?= $page; ?> of <?= $total_pages; ?> pages</p>
    <div>
      <!-- Previous Button -->
      <a href="<?= $base_url ?>?<?= http_build_query(array_merge($params, ['page' => max(1, $page - 1)])) ?>" class="hover:bg-slate-200 text-blue-800 font-semibold border border-slate-400 px-4 py-[7px] mr-3 rounded-md transition-all duration-300">
        <i class="fa-solid fa-chevron-left mr-3"></i>Prev
      </a>

      <!-- First Page Link & Ellipsis -->
      <?php if ($page > 3) : ?>
        <a href="<?= $base_url ?>?<?= http_build_query(array_merge($params, ['page' => 1])) ?>" class="px-3 py-[7px] font-semibold rounded-md border border-slate-400 hover:bg-gray-200 transition-all duration-300">1</a>
        <?php if ($page > 4) : ?>
          <span class="px-3 py-2 font-semibold">...</span>
        <?php endif; ?>
      <?php endif; ?>

      <!-- Dynamic Page Links -->
      <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++) : ?>
        <a href="<?= $base_url ?>?<?= http_build_query(array_merge($params, ['page' => $i])) ?>" class="px-3 py-[7px] font-semibold rounded-md border border-slate-400 hover:bg-opacity-90 <?= $i == $page ? 'bg-amber-500 text-slate-100' : '' ?>"><?= $i; ?></a>
      <?php endfor; ?>

      <!-- Last Page Link & Ellipsis -->
      <?php if ($page < $total_pages - 2) : ?>
        <?php if ($page < $total_pages - 3) : ?>
          <span class="px-3 py-2 font-semibold">...</span>
        <?php endif; ?>
        <a href="<?= $base_url ?>?<?= http_build_query(array_merge($params, ['page' => $total_pages])) ?>" class="px-3 py-[7px] font-semibold rounded-md border border-slate-400 hover:bg-gray-200 transition-all duration-300"><?= $total_pages; ?></a>
      <?php endif; ?>

      <!-- Next Button -->
      <a href="<?= $base_url ?>?<?= http_build_query(array_merge($params, ['page' => min($total_pages, $page + 1)])) ?>" class="bg-blue-700 hover:bg-blue-800 text-slate-100 font-semibold px-4 py-[7px] ml-3 rounded-md">
        Next<i class="fa-solid fa-chevron-right ml-3"></i>
      </a>
    </div>
  </section>
<?php
  return ob_get_clean();
}
?>