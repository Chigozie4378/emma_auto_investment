<?php
class Pagination
{
    public $limit;
    public $offset;
    public $page;
    public $totalRecords;
    public $totalPages;
    public $baseUrl;

    public function __construct($totalRecords, $limit = 50, $baseUrl = '')
    {
        $this->page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
        $this->limit = $limit;
        $this->offset = ($this->page - 1) * $limit;
        $this->totalRecords = $totalRecords;
        $this->totalPages = ceil($totalRecords / $limit);
        $this->baseUrl = $baseUrl ?: $_SERVER['PHP_SELF'];
    }

    public function render()
    {
        if ($this->totalPages <= 1) return '';

        $html = '<ul class="pagination">';
        $range = 5;
        $start = max($this->page - $range, 1);
        $end = min($this->page + $range, $this->totalPages);

        // Show first page link if not in range
        if ($start > 1) {
            $html .= $this->link(1, "1");
        }

        // Prev link
        if ($this->page > 1) {
            $html .= $this->link($this->page - 1, "Prev");
        }

        // Main page loop
        for ($i = $start; $i <= $end; $i++) {
            $active = ($i == $this->page) ? "active" : "";
            $html .= $this->link($i, $i, $active);
        }

        // Next link
        if ($this->page < $this->totalPages) {
            $html .= $this->link($this->page + 1, "Next");
        }

        // Last page link if not in range
        if ($end < $this->totalPages) {
            $html .= $this->link($this->totalPages, $this->totalPages);
        }

        $html .= '</ul>';
        return $html;
    }



    private function link($page, $label, $class = '')
    {
        return "<li class='page-item {$class}'><a class='page-link' href='{$this->baseUrl}?page={$page}'>{$label}</a></li>";
    }
}
