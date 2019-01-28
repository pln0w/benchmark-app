<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Benchmark report</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
</head>
<body>

<section class="section">

  <div class="container">
    <strong>REPORT</strong>
  </div>

  <div class="container">
    The website URL you compare with others: <strong><?= $theWebsiteUrl ?? 'none' ?></strong>
  </div>

  <div class="container">

    <table class="table is-fullwidth">
      <thead>
      <tr>
        <th>Score</th>
        <th>URL</th>
        <th>Request time</th>
      </tr>
      </thead>
      <tbody>

      <?php $position = 1; ?>

      <?php
      if (isset($results)) {
          foreach ($results as $result): ?>

            <tr class="<?php
            echo (!$result->isTheWebsite()) ?: ' has-text-weight-bold';
            echo (1 !== $position) ?: ' is-selected';
            ?>">
              <td><?= $position ?></td>
              <td><?= $result->getWebsite()->getUrl() ?></td>
              <td><?= $result->getFormattedRequestTime() ?> s</td>
            </tr>

              <?php $position++; ?>

          <?php endforeach;
      }
      ?>

      </tbody>
    </table>
  </div>
</section>

</body>
</html>
