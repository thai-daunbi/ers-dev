<?php

class Array_View_Table {

    private $view_value;
    private $view_display;

    public function view($array_value) {
        if (!empty($array_value)) {
            $this->view_value = $array_value;
            $this->view_display = '<table class="lucen">';
            $this->table_view();
            $this->view_display .= '</table>';
        }
		else {
			$this->tbl_display = "<table class='lucen'><tr><td> value not found. </td></tr></table>";
		}
        return $this->view_display;
    }

    public function table_view() {
        if (!empty($this->view_value)) {
            $first = reset($this->view_value);
            $this->view_display .= '<tr>';
            foreach ($first as $title =>$tmp) {
                $this->view_display .= '<th>' . $title . '</th>';
            }
            $this->view_display .= '</tr>';
            foreach ($this->view_value as $array_value) {
                $this->view_display .= '<tr>';
                foreach ($array_value as $value) {
                    $this->view_display .= '<td>' . $value . '</td>';
                }
                $this->view_display .= '</tr>';
            }
        }
    }
}