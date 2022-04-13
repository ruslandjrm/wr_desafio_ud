<?php 

// WP_List_Table is not loaded automatically so we need to load it in our application
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Example_List_Table extends WP_List_Table {
    /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->table_data();
        usort( $data, array( &$this, 'sort_data' ) );

        $perPage = 10;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);

        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );

        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }

    /**
     * Override the parent columns method. Defines the columns to use in your listing table
     *
     * @return Array
     */
    public function get_columns()
    {
        $columns = array(
            'id'  => 'ID page',
            'error_link'  => 'Error link',
            'status_link' => 'Estado ',
            'post_title'  => 'Origen',
        );

        return $columns;
    }

    /**
     * Define which columns are hidden
     *
     * @return Array
     */
    public function get_hidden_columns()
    {
        return array();
    }

    /**
     * Define the sortable columns
     *
     * @return Array
     */
    public function get_sortable_columns()
    {
        return array('title' => array('title', false));
    }

    /**
     * Get the table data
     *
     * @return Array
     */

     
    private function table_data()
    {
        $data = array();
        
        $args = array(
            'posts_per_page'   => -1,
            'post_type'        => 'post',
        );
        $the_query = new WP_Query( $args );
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $dataLinks = get_all_link_of_page(get_the_content());
            $errorCode = "";
            $errorLinkType = "";

       
            foreach($dataLinks as $key => $link) {
                echo $key.'--'.$link['href'];
                if (strpos($link['href'], ' ') !== false) {
                    $errorCode = "%20".trim($link['href']);
                    $errorLinkType = "Enlace malformado";
                }
                elseif ( (strpos($link['href'], 'http') !== 0) ) {
                    $errorCode = trim($link['href']);
                    $errorLinkType = "Protocolo no especificado";
                }
                elseif (review404($link['href'])) {
                    $errorCode = $link['href'];
                    $errorLinkType = "404 No existe";
                }
                else {
                    $errorCode = "";
                    $errorLinkType = "";
                }

                if($errorCode != "") {
                    $data[] = array(
                        'id'  => get_the_id(),
                        'error_link'  => $errorCode,
                        'status_link' => $errorLinkType,
                        'post_title' => '<a href="'.get_the_permalink().'">'.get_the_title().'</a>',
                    );
                }
            }
        }
        wp_reset_postdata();
        return $data;
    }

    /**
     * Define what data to show on each column of the table
     *
     * @param  Array $item        Data
     * @param  String $column_name - Current column name
     *
     * @return Mixed
     */
    public function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            case 'id':
            case 'error_link':
            case 'status_link':
            case 'post_title':
                return $item[ $column_name ];
            default:
                return print_r( $item, true ) ;
        }
    }

    /**
     * Allows you to sort the data by the variables set in the $_GET
     *
     * @return Mixed
     */
    private function sort_data( $a, $b )
    {
        // Set defaults
        $orderby = 'title';
        $order = 'asc';

        // If orderby is set, use this as the sort column
        if(!empty($_GET['orderby']))
        {
            $orderby = $_GET['orderby'];
        }

        // If order is set use this as the order
        if(!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }


        $result = strcmp( $a[$orderby], $b[$orderby] );

        if($order === 'asc')
        {
            return $result;
        }

        return -$result;
    }
}


$exampleListTable = new Example_List_Table();
$exampleListTable->prepare_items();
?>
    <div class="wrap">
        <div id="icon-users" class="icon32"></div>
        <h2>Example List Table Page</h2>
        <?php $exampleListTable->display(); ?>
    </div>