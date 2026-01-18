<?php
session_start();
include("dbconfig.php"); // must set $pdo (PDO instance)

// Messages to show inline
$errorMessage = "";
$successMessage = "";

try {
    // ===== REGISTER =====
    if (isset($_POST['register'])) {
        $full_name = trim($_POST['full_name'] ?? '');
        $student_number = trim($_POST['student_number'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        $email = $POST['email'] ?? '';
        if ($full_name === '' || $student_number === '' || $password === '' || $confirm === '') {
            $errorMessage = "Please fill in all registration fields.";
        } elseif (!is_numeric($student_number)) {
            $errorMessage = "Student number must be numeric.";
        } elseif ($password !== $confirm) {
            $errorMessage = "Passwords do not match.";
        } else {
            // Check uniqueness
            $checkSql = "SELECT id FROM students WHERE student_number = :sn LIMIT 1";
            $stmt = $pdo->prepare($checkSql);
            $stmt->execute([':sn' => $student_number]);
            if ($stmt->fetch()) {
                $errorMessage = "Student number already registered.";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $ins = "INSERT INTO students (full_name, student_number, password, status, course, email) VALUES (:fn, :sn, :pw, 'Active', 'BSIT', :email);";
                $stmt = $pdo->prepare($ins);
                $stmt->execute([
                    ':fn' => $full_name,
                    ':sn' => $student_number,
                    ':pw' => $hash,
                    ':email' => $email
                ]);
                $successMessage = "Registration successful. You can now log in.";
            }
        }
    }

    // ===== LOGIN =====
    if (isset($_POST['login'])) {
        $username = trim($_POST['studentNumber'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            $errorMessage = "Please fill in both login fields.";
        } else {
            if (!is_numeric($username)) {
                // Admin login (non-numeric)
                $sql = "SELECT * FROM admin WHERE username = :username LIMIT 1";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':username' => $username]);
                $admin = $stmt->fetch(PDO::FETCH_OBJ);

                if ($admin && password_verify($password, $admin->password)) {
                    $_SESSION['admin_name'] = $admin->admin_name;
                    $_SESSION['loggedin'] = true;
                    header("Location: admin/dashboard.php");
                    exit();
                } else {
                    $errorMessage = "Invalid admin username or password.";
                }
            } else {
                // Student login
                $loginsql = "SELECT * FROM students WHERE student_number = :username LIMIT 1";
                $stmt = $pdo->prepare($loginsql);
                $stmt->execute([":username" => $username]);
                $user = $stmt->fetch(PDO::FETCH_OBJ);

                if ($user && password_verify($password, $user->password)) {
                    if (strtolower($user->status) === 'blacklisted') {
                        $errorMessage = "Your account is in our Blacklist.";
                    } elseif (strtolower($user->status) === 'active') {
                        $_SESSION['student_name'] = $user->full_name;
                        $_SESSION['student_number'] = $user->student_number;
                        $_SESSION['user_id'] = $user->id;
                        $_SESSION['userloggedin'] = true;
                        header("Location: user/home.php");
                        exit();
                    } else {
                        $errorMessage = "Account status doesn't allow login. Contact admin.";
                    }
                } else {
                    $errorMessage = "Invalid student number or password.";
                }
            }
        }
    }

} catch (PDOException $e) {
    // In production, log $e->getMessage() instead of showing it.
    $errorMessage = "Database error: " . $e->getMessage();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" >
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Urban Reads — Login / Register</title>

  <link rel="icon" type="image/png" href="includes/logo1.png" />

  
  <!-- Bootstrap 4.5.2 CSS (same version used for JS) -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <!-- Font Awesome 5.15.3 (same major version you used) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

  <!-- Optional: your custom CSS -->
  <link rel="stylesheet" href="includes/style.css">

  <style>
    /* Minimal design: centered, small card */
    html,body { height:100%; background:#f7f9fc; }
    .center-wrap { min-height:100vh; display:flex; align-items:center; justify-content:center; }
    .card.minimal { border:0; border-radius:10px; box-shadow: 0 6px 18px rgba(35,44,60,.08); padding:18px; width:360px; background:#ffffff; }
    .brand { display:flex; align-items:center; gap:10px; margin-bottom:12px; }
    .brand img { height:36px; }
    .nav-pills .nav-link { border-radius:6px; }
    .form-small { font-size:14px; }
    .svg-background { position: absolute; inset:0; width:100%; height:100%; z-index:0; pointer-events:none; opacity:0.06; }
  </style>
</head>
<body>
  <div class="svg-background">
    <!-- keep your large SVG if you want; placeholder to keep markup minimal -->
    <!-- Optional: paste your existing SVG here -->
  </div>

  <div class="center-wrap">
    <div class="card minimal" role="region" aria-label="Auth card">
      <div class="brand">
        <img src="includes/logo1.png" alt="UrbanReads logo">
        <h5 class="m-0">UrbanReads</h5>
      </div>

      <?php if ($errorMessage): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?php echo htmlspecialchars($errorMessage); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span>&times;</span></button>
        </div>
      <?php endif; ?>

      <?php if ($successMessage): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?php echo htmlspecialchars($successMessage); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span>&times;</span></button>
        </div>
      <?php endif; ?>

      <!-- Tabs -->
      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item w-50">
          <a class="nav-link active text-center" id="login-tab" data-toggle="pill" href="#login" role="tab">Login</a>
        </li>
        <li class="nav-item w-50">
          <a class="nav-link text-center" id="register-tab" data-toggle="pill" href="#register" role="tab">Register</a>
        </li>
      </ul>

      <div class="tab-content">
        <!-- LOGIN -->
        <div class="tab-pane fade show active" id="login" role="tabpanel">
          <form method="post" action="" autocomplete="off" class="form-small">
            <div class="form-group">
              <label for="studentNumber">Student Number / Username</label>
              <input type="text" class="form-control form-control-sm" id="studentNumber" name="studentNumber"
                     value="<?php echo isset($_POST['studentNumber']) ? htmlspecialchars($_POST['studentNumber']) : ''; ?>" required>
              <small class="form-text text-muted">Enter student number (numeric) or admin username (non-numeric).</small>
            </div>

            <div class="form-group">
              <label for="password1">Password</label>
              <input type="password" class="form-control form-control-sm" id="password1" name="password" required>
            </div>

            <button type="submit" name="login" class="btn btn-primary btn-block btn-sm">
              <i class="fas fa-sign-in-alt mr-1"></i> Login
            </button>
          </form>
        </div>

        <!-- REGISTER -->
        <div class="tab-pane fade" id="register" role="tabpanel">
          <form method="post" action="" autocomplete="off" class="form-small mt-2">
            <div class="form-group">
              <label for="full_name">Full name</label>
              <input type="text" class="form-control form-control-sm" id="full_name" name="full_name"
                     value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>" required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control form-control-sm" id="email" name="email"
                     value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>

            <div class="form-group">
              <label for="student_number">Student number</label>
              <input type="text" class="form-control form-control-sm" id="student_number" name="student_number"
                     value="<?php echo isset($_POST['student_number']) ? htmlspecialchars($_POST['student_number']) : ''; ?>" required>
            </div>

            <div class="form-row">
              <div class="form-group col">
                <label for="password">Password</label>
                <input type="password" class="form-control form-control-sm" id="password" name="password" required>
              </div>
              <div class="form-group col">
                <label for="confirm_password">Confirm</label>
                <input type="password" class="form-control form-control-sm" id="confirm_password" name="confirm_password" required>
              </div>
            </div>

            <button type="submit" name="register" class="btn btn-outline-primary btn-block btn-sm">
              <i class="fas fa-user-plus mr-1"></i> Register
            </button>
            <small class="form-text text-muted text-center mt-2">By registering you accept the site terms.</small>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery 3.5.1 slim, Popper 1.16.0, Bootstrap 4.5.2 JS (same versions) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    // Keep tabs client-side minimal: activate pill from hash if present
    (function(){
      var hash = window.location.hash;
      if (hash) {
        var target = document.querySelector('a[href="'+hash+'"]');
        if (target) { $(target).tab('show'); }
      }
    })();
  </script>
</body>
</html>
