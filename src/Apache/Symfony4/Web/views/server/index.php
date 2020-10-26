<div class="container">

    <?php foreach ($links as $group): ?>
        <h2><?= $group['title'] ?></h2>
        <ul class="list-group">
            <?php foreach ($group['items'] as $link): ?>
                <?php
                /** @var \ZnSandbox\Sandbox\Apache\Domain\Entities\ServerEntity $serverEntity */
                $serverEntity = $link['server'];
                ?>
                <li class="list-group-item list-group-item-action">
                    <div class="pull-right">
                        <a href="/view?name=<?= $serverEntity->getServerName() ?>" class="text-decoration-none text-dark">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="/update?name=<?= $serverEntity->getServerName() ?>" class="">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="/delete?name=<?= $serverEntity->getServerName() ?>" class="text-danger" data-method="post"
                           data-confirm="Удалить хост?">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                    <?php include(__DIR__ . '/_title.php') ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>

</div>