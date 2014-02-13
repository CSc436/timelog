public function __construct() {
    $this->beforeFilter('csrf', array('on'=>'post'));
}