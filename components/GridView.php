<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.07.16.
 * Time: 10:38
 */

namespace app\components;

use app\controllers\GridViewController;
use kartik\grid\GridView as GridViewBase;
use kartik\widgets\Select2;
use Yii;
use yii\helpers\Url;

class GridView extends GridViewBase
{

    private $change_function = <<< HTML
function() {
        var val=$('[name="pageSize"]').val();
        $.get( '#url#', { pagesize: val, class: '#class#' } )
  .done(function( data ) {
location.reload();
  });
}


HTML;

    public $panelBeforeTemplate = <<< HTML

    <div class="kv-panel-pager pull-left">
    {pager}
    </div>

    <div class="pull-right">
        <div class="btn-toolbar kv-grid-toolbar" role="toolbar">
            {toolbar}
        </div>
    </div>
    {before}
    <div class="clearfix"></div>
HTML;

    public function __construct($config = [])
    {
        parent::__construct($config);

        $pre = '<div class="btn-group"><div class="input-group input-group-md" style="width:60px">';
        $post = '</div></div>';

        $data = array_combine(range(10, 100, 10), range(10, 100, 10));
        $filterModel = $config['filterModel'];
        $initSize = GridViewController::getPageSize($filterModel->className());

        $cf = str_replace('#url#', Url::toRoute('/grid-view/set-page-size'),$this->change_function);
        $cf = str_replace('#class#', $filterModel->className(),$cf);

        $this->toolbar = [
            [
                'content' => $pre . Select2::widget([
                        'name'         => 'pageSize',
                        'data'         => $data,
                        'value'        => $initSize,
                        'pluginEvents' => [
                            "change" => $cf,
                        ]
                    ]) . $post
            ],
            '{toggleData}',
            '{export}',
        ];
    }
}