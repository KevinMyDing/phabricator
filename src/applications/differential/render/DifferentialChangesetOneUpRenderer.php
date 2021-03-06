<?php

final class DifferentialChangesetOneUpRenderer
  extends DifferentialChangesetHTMLRenderer {

  public function isOneUpRenderer() {
    return true;
  }

  public function renderTextChange(
    $range_start,
    $range_len,
    $rows) {

    $primitives = $this->buildPrimitives($range_start, $range_len);

    $out = array();
    foreach ($primitives as $p) {
      $type = $p['type'];
      switch ($type) {
        case 'old':
        case 'new':
          $out[] = hsprintf('<tr>');
          if ($type == 'old') {
            if ($p['htype']) {
              $class = 'left old';
            } else {
              $class = 'left';
            }
            $out[] = phutil_tag('th', array(), $p['line']);
            $out[] = phutil_tag('th', array());
            $out[] = phutil_tag('td', array('class' => $class), $p['render']);
          } else if ($type == 'new') {
            if ($p['htype']) {
              $class = 'right new';
              $out[] = phutil_tag('th', array());
            } else {
              $class = 'right';
              $out[] = phutil_tag('th', array(), $p['oline']);
            }
            $out[] = phutil_tag('th', array(), $p['line']);
            $out[] = phutil_tag('td', array('class' => $class), $p['render']);
          }
          $out[] = hsprintf('</tr>');
          break;
        case 'inline':
          $out[] = hsprintf('<tr><th /><th />');
          $out[] = hsprintf('<td>');

          $inline = $this->buildInlineComment(
            $p['comment'],
            $p['right']);
          $inline->setBuildScaffolding(false);
          $out[] = $inline->render();

          $out[] = hsprintf('</td></tr>');
          break;
        default:
          $out[] = hsprintf('<tr><th /><th /><td>%s</td></tr>', $type);
          break;
      }
    }

    if ($out) {
      return $this->wrapChangeInTable(phutil_implode_html('', $out));
    }
    return null;
  }

  public function renderFileChange(
    $old_file = null,
    $new_file = null,
    $id = 0,
    $vs = 0) {

    throw new PhutilMethodNotImplementedException();
  }

}
