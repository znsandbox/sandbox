<?php


/**
 * @var $this \ZnLib\Web\View\View
 * @var $rpcResponseEntity \ZnLib\Rpc\Domain\Entities\RpcResponseEntity
 * @var $rpcRequestEntity \ZnLib\Rpc\Domain\Entities\RpcRequestEntity
 */

use ZnCore\Domain\Helpers\EntityHelper;
use ZnLib\Rpc\Domain\Encoders\RequestEncoder;
use ZnLib\Rpc\Domain\Encoders\ResponseEncoder;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\ApiKeyEntity;

$responseEncoder = new ResponseEncoder();
$responseData = $responseEncoder->encode(EntityHelper::toArray($rpcResponseEntity, true));

$requestEncoder = new RequestEncoder();
$requestData = $requestEncoder->encode(EntityHelper::toArray($rpcRequestEntity, true));

if(empty($requestData['params']['body'])) {
    unset($requestData['params']['body']);
}
if(empty($requestData['params']['meta'])) {
    unset($requestData['params']['meta']);
}
if(empty($requestData['params'])) {
    unset($requestData['params']);
}

$responseCode = json_encode($responseData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
$requestCode = json_encode($requestData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>

<ul class="nav nav-tabs" id="result-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="result-response-tab" data-toggle="pill" href="#result-response"
           role="tab" aria-controls="result-response" aria-selected="true">response</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="result-request-tab" data-toggle="pill" href="#result-request" role="tab"
           aria-controls="result-request" aria-selected="false">request</a>
    </li>
</ul>

<?php if ($rpcRequestEntity): ?>
    <div class="tab-content" id="result-tabContent">
        <div class="tab-pane fade active show" id="result-response" role="tabpanel"
             aria-labelledby="result-response-tab">
            <?php if ($rpcResponseEntity): ?>
                <small>
                    <pre><code><?= htmlspecialchars($responseCode) ?></code></pre>
                </small>
            <?php endif; ?>
        </div>
        <div class="tab-pane fade" id="result-request" role="tabpanel" aria-labelledby="result-request-tab">
            <?php if ($rpcRequestEntity): ?>
                <small>
                    <pre><code><?= htmlspecialchars($requestCode) ?></code></pre>
                </small>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

