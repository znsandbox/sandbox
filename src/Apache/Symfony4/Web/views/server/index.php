
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="container">

    <?php foreach ($links as $group): ?>
        <h2><?= $group['title'] ?></h2>
        <ul class="list-group">
            <?php foreach ($group['items'] as $link): ?>
                <li class="list-group-item list-group-item-action">
                    <div class="pull-right">
                        <a href="/view?name=<?= $link['name'] ?>" class="text-decoration-none text-dark">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="/update?name=<?= $link['name'] ?>" class="">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="/delete?name=<?= $link['name'] ?>" class="text-danger" data-method="post" data-confirm="Удалить хост?">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                    <a href="<?= $link['url'] ?>" class="">
                        <?= $link['title'] ?: $link['name'] ?>
                    </a>
                    <?php if (!empty($link['description'])): ?>
                        <span class="text-secondary">
                            <small>
                                <?= $link['description'] ?>
                            </small>
                        </span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>

</div>