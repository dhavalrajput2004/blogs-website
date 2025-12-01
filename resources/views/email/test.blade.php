<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome — {{ $name }}</title>
  <style>
    /* CLIENT-SAFE STYLES */
    body,table,td{font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;}
    img{border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;}
    a{color:inherit;text-decoration:none;}

    /* GENERAL */
    .wrapper{width:100%;background-color:#f4f6f8;padding:24px 0}
    .email-container{max-width:600px;margin:0 auto;background:#ffffff;border-radius:8px;overflow:hidden}
    .spacer{height:24px}

    /* HEADER */
    .header{padding:24px;text-align:center}
    .logo{max-width:140px;height:auto}

    /* BODY */
    .content{padding:0 28px 28px}
    h1{font-size:22px;margin:16px 0 8px;color:#111827}
    p{margin:0 0 12px;color:#334155;line-height:1.5}

    /* CTA */
    .btn{display:inline-block;padding:12px 20px;border-radius:6px;background:#0ea5a4;color:#ffffff;font-weight:600}

    /* FOOTER */
    .footer{padding:20px 28px;background:#f8fafc;color:#94a3b8;font-size:13px;text-align:center}

    /* Responsive */
    @media screen and (max-width:420px){
      .email-container{margin:0 12px}
      h1{font-size:20px}
    }
  </style>
</head>
<body style="margin:0;padding:0;background:#f4f6f8;">
  <center class="wrapper">
    <table role="presentation" class="email-container" width="100%" cellpadding="0" cellspacing="0">
     

      <tr>
        <td class="content">
          <h1>Welcome, {{ $name }} 👋</h1>
          <p>Thanks for joining — we’re thrilled to have you onboard. You’re all set to explore the best we have to offer.</p>

          <p><strong>Here’s what to do next:</strong></p>
          <ul style="margin:8px 0 16px;padding-left:18px;color:#334155">
            <li>Complete your profile to get personalized recommendations.</li>
            <li>Explore our <a href="#">Getting Started</a> guide for quick tips.</li>
            <li>Visit your dashboard to see your account at a glance.</li>
          </ul>

          <p style="text-align:center;margin-top:10px">
            <a class="btn" href="#">Get Started</a>
          </p>

          <div class="spacer"></div>

          <p>If you have any questions, reply to this email — we’re happy to help.</p>

          <p>Cheers,<br><strong>The Blog Team</strong></p>
        </td>
      </tr>

      <tr>
        <td class="footer">
          <p style="margin:0 0 8px">Need help? Visit our <a href="#">Help Center</a> or email</p>
          <p style="margin:8px 0 0;font-size:12px;color:#9aa6b2">You’re receiving this email because you signed up for If you didn’t, you can.</p>
        </td>
      </tr>
    </table>
  </center>
</body>
</html>

