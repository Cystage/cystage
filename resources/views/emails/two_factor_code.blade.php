<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Code de connexion</title></head>
<body style="margin:0;padding:0;background:#f4f6fb;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6fb;padding:40px 0;">
  <tr><td align="center">
    <table width="520" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.07);">

      <tr>
        <td style="background:#2563eb;padding:28px 40px;">
          <p style="margin:0;font-size:22px;font-weight:700;color:#ffffff;">CyStage</p>
        </td>
      </tr>

      <tr>
        <td style="padding:36px 40px 12px;">
          <h1 style="margin:0 0 8px;font-size:20px;color:#0f172a;">Votre code de vérification</h1>
          <p style="margin:0;color:#64748b;font-size:15px;">Utilisez ce code pour finaliser votre connexion.</p>
        </td>
      </tr>

      <tr>
        <td style="padding:20px 40px 32px;">
          <div style="background:#eff6ff;border:2px solid #bfdbfe;border-radius:12px;padding:24px;text-align:center;">
            <p style="margin:0;font-size:42px;font-weight:800;letter-spacing:12px;color:#1d4ed8;">{{ $user->two_factor_code }}</p>
          </div>
          <p style="margin:16px 0 0;font-size:13px;color:#94a3b8;text-align:center;">Ce code expire dans <strong>5 minutes</strong>. Ne le partagez avec personne.</p>
        </td>
      </tr>

      <tr>
        <td style="border-top:1px solid #e2e8f0;padding:20px 40px;">
          <p style="margin:0;font-size:12px;color:#94a3b8;">Si vous n'avez pas tenté de vous connecter, ignorez cet email.</p>
        </td>
      </tr>

    </table>
  </td></tr>
</table>
</body>
</html>
