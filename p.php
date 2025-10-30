<?php
// index.php
// Simple demo: hash a password using Argon2i and verify it.
// Requires PHP 7.2+ with Argon2 support (check with defined('PASSWORD_ARGON2I')).

function safe_post($key) {
    return isset($_POST[$key]) ? trim((string)$_POST[$key]) : '';
}

$canUseArgon2i = defined('PASSWORD_ARGON2I');
$hash = null;
$verify_result = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = safe_post('password');
    $confirm = safe_post('confirm'); // optional second field to verify

    if ($password === '') {
        $error = 'Please enter a password to hash.';
    } elseif (!$canUseArgon2i) {
        $error = 'Argon2i is not available on this PHP installation. See your PHP version and build options.';
    } else {
        // Argon2i options — tune for your environment.
        // memory_cost is in kibibytes (so 1<<16 = 65536 KiB = 64 MiB)
        // time_cost is number of iterations
        // threads is parallelism (number of lanes)
        $options = [
            'memory_cost' => 1 << 16, // 65536 KiB = 64 MiB
            'time_cost'   => 4,       // iterations
            'threads'     => 2        // parallelism
        ];

        // Create the hash
        $hash = password_hash($password, PASSWORD_ARGON2I, $options);

        if ($hash === false) {
            $error = 'Hashing failed (password_hash returned false).';
        } else {
            // If user provided a confirmation string, check verification demonstration
            if ($confirm !== '') {
                $verify_result = password_verify($confirm, $hash) ? 'MATCH' : 'NO MATCH';
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Argon2i Hash Demo</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
body{font-family:system-ui,Segoe UI,Roboto,Arial;padding:20px;background:#f7f8fb;color:#111}
.card{background:#fff;padding:18px;border-radius:10px;max-width:720px;margin:0 auto;box-shadow:0 6px 20px rgba(0,0,0,0.06)}
label{display:block;margin-top:10px}
input[type="password"],textarea{width:100%;padding:8px;margin-top:6px;border-radius:6px;border:1px solid #ddd;font-family:monospace}
button{margin-top:12px;padding:10px 14px;border-radius:8px;border:0;background:#2563eb;color:#fff;cursor:pointer}
pre{background:#0b1220;color:#e6edf3;padding:12px;border-radius:8px;overflow:auto}
.small{font-size:0.9rem;color:#555}
.error{color:#b00020}
.success{color:#027a48}
</style>
</head>
<body>
<div class="card">
  <h1>Argon2i Password Hash (demo)</h1>

  <?php if (!$canUseArgon2i): ?>
    <p class="error">Warning: <strong>Argon2i is not available</strong> on this PHP build. This demo requires PHP 7.2+ with Argon2 support.</p>
  <?php endif; ?>

  <?php if ($error): ?>
    <p class="error"><?=htmlspecialchars($error)?></p>
  <?php endif; ?>

  <form method="post" autocomplete="off">
    <label for="password">Password to hash</label>
    <input id="password" name="password" type="password" required>

    <label for="confirm">(Optional) Verify by entering the password again</label>
    <input id="confirm" name="confirm" type="password">

    <div class="small">Using Argon2i with options: memory_cost=<?= (1<<16) ?> KiB, time_cost=4, threads=2</div>

    <button type="submit">Hash &amp; Verify</button>
  </form>

  <?php if ($hash): ?>
    <h2>Result</h2>
    <p class="small">Below is the Argon2i hash (store this in your DB — never store plaintext):</p>
    <pre><?=htmlspecialchars($hash)?></pre>

    <?php if ($verify_result !== null): ?>
      <p>Verification result: 
      <?php if ($verify_result === 'MATCH'): ?>
        <span class="success">MATCH ✅ — the confirmation matches the hashed password.</span>
      <?php else: ?>
        <span class="error">NO MATCH ❌ — the confirmation did NOT match.</span>
      <?php endif; ?>
      </p>
    <?php else: ?>
      <p class="small">Tip: Use the confirmation field to test password_verify().</p>
    <?php endif; ?>
  <?php endif; ?>

  <hr>
  <h3>Notes & Recommendations</h3>
  <ul class="small">
    <li>Argon2id is generally recommended for new applications because it provides combined resistance to side-channel and GPU attacks; if available, prefer <code>PASSWORD_ARGON2ID</code>.</li>
    <li>Tune <strong>memory_cost</strong>, <strong>time_cost</strong>, and <strong>threads</strong> for your server hardware. The example uses 64 MiB memory and 4 iterations.</li>
    <li>Always store only the hash (as shown) and use <code>password_verify()</code> to check passwords.</li>
    <li>Make sure your PHP has Argon2 support: <code>php -r "var_export(defined('PASSWORD_ARGON2I'));"</code> should print <code>true</code>.</li>
  </ul>
</div>
</body>
</html>
