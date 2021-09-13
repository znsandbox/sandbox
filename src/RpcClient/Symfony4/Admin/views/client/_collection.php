<?php

/**
 * @var $baseUri string
 * @var $favoriteEntity \ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity | null
 * @var $collection \Illuminate\Support\Collection | \ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity[]
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use ZnCore\Base\Helpers\StringHelper;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Libs\DataProvider;
use ZnLib\Rpc\Domain\Encoders\RequestEncoder;
use ZnLib\Rpc\Domain\Encoders\ResponseEncoder;
use ZnLib\Web\Widgets\Format\Formatters\ActionFormatter;
use ZnLib\Web\Widgets\Format\Formatters\LinkFormatter;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\ApiKeyEntity;

?>

    <!--<a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                        The current link item
                    </a>-->
<?php foreach ($collection as $favoriteEntityItem): ?>
    <a href="<?= \ZnCore\Base\Legacy\Yii\Helpers\Url::to([$baseUri, 'id' => $favoriteEntityItem->getId()]) ?>"
       class="list-group-item list-group-item-action <?= $favoriteEntity && ($favoriteEntity->getId() == $favoriteEntityItem->getId()) ? 'active' : '' ?>">
        <small>
            <?= $favoriteEntityItem->getMethod() ?>
            <?php if ($favoriteEntityItem->getDescription()): ?>
                <br/>
                <?= $favoriteEntityItem->getDescription() ?>
            <?php endif; ?>
        </small>
    </a>
<?php endforeach; ?>