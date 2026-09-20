<?php
// search.php — AJAX Search endpoint
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$verses = json_decode(file_get_contents(__DIR__ . '/verses.json'), true);

$query   = isset($_GET['q'])     ? strtolower(trim($_GET['q']))     : '';
$theme   = isset($_GET['theme']) ? strtolower(trim($_GET['theme'])) : '';
$chapter = isset($_GET['chapter']) ? intval($_GET['chapter'])       : 0;

$results = array_filter($verses, function($v) use ($query, $theme, $chapter) {
  $matchQuery   = !$query   || stripos($v['english'], $query) !== false
                             || stripos($v['transliteration'], $query) !== false
                             || stripos($v['sanskrit'], $query) !== false;
  $matchTheme   = !$theme   || $v['theme'] === $theme;
  $matchChapter = !$chapter || $v['chapter'] === $chapter;
  return $matchQuery && $matchTheme && $matchChapter;
});

echo json_encode([
  'success' => true,
  'count'   => count($results),
  'results' => array_values($results)
]);