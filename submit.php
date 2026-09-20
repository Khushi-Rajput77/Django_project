<?php
// submit.php — Reflection form handler
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$dataFile = __DIR__ . '/reflections.json';

// ---- GET: Return existing reflections ----
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get') {
  $reflections = [];
  if (file_exists($dataFile)) {
    $reflections = json_decode(file_get_contents($dataFile), true) ?? [];
  }
  // Return latest 10 first
  $reflections = array_reverse($reflections);
  $reflections = array_slice($reflections, 0, 10);
  echo json_encode(['success' => true, 'reflections' => $reflections]);
  exit;
}

// ---- POST: Save new reflection ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name       = trim(htmlspecialchars($_POST['name']       ?? '', ENT_QUOTES));
  $verse      = trim(htmlspecialchars($_POST['verse']      ?? '', ENT_QUOTES));
  $reflection = trim(htmlspecialchars($_POST['reflection'] ?? '', ENT_QUOTES));

  if (empty($name) || empty($reflection)) {
    echo json_encode(['success' => false, 'message' => 'Name and reflection are required.']);
    exit;
  }

  

  if (strlen($reflection) > 1000) {
    echo json_encode(['success' => false, 'message' => 'Reflection is too long (max 1000 characters).']);
    exit;
  }

  // Load existing
  $reflections = [];
  if (file_exists($dataFile)) {
    $reflections = json_decode(file_get_contents($dataFile), true) ?? [];
  }

  // Add new
  $reflections[] = [
    'id'         => uniqid(),
    'name'       => $name,
    'verse'      => $verse,
    'reflection' => $reflection,
    'date'       => date('d M Y, H:i')
  ];

  // Save (keep max 100 reflections)
  if (count($reflections) > 100) {
    $reflections = array_slice($reflections, -100);
  }

  if (file_put_contents($dataFile, json_encode($reflections, JSON_PRETTY_PRINT))) {
    echo json_encode(['success' => true, 'message' => 'Your reflection has been saved. Jai Shri Krishna! 🙏']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Could not save reflection. Check folder permissions.']);
  }
  exit;
}

// Fallback
echo json_encode(['success' => false, 'message' => 'Invalid request.']);