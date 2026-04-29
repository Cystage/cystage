<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Stage confirmé</title></head>
<body style="margin:0;padding:0;background:#f4f6fb;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6fb;padding:40px 0;">
  <tr><td align="center">
    <table width="560" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.07);">

      <tr>
        <td style="background:#2563eb;padding:28px 40px;">
          <p style="margin:0;font-size:22px;font-weight:700;color:#ffffff;">CyStage</p>
        </td>
      </tr>

      <tr>
        <td style="padding:36px 40px 20px;">
          <h1 style="margin:0 0 8px;font-size:20px;color:#0f172a;">Stage confirmé par l'étudiant</h1>
          <p style="margin:0;color:#64748b;font-size:15px;">Pour votre offre <strong>{{ $postulation->offre->nom }}</strong></p>
        </td>
      </tr>

      <tr>
        <td style="padding:0 40px 32px;">
          <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;">
            <tr>
              <td style="padding:20px 24px;">
                <p style="margin:0 0 10px;font-size:13px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em;">Stagiaire confirmé</p>
                <p style="margin:0;font-size:16px;color:#0f172a;font-weight:600;">{{ $postulation->etudiant->prenom }} {{ $postulation->etudiant->nom }}</p>
                <p style="margin:4px 0 0;font-size:14px;color:#64748b;">N° {{ $postulation->etudiant->num_etudiant }}</p>
              </td>
            </tr>
          </table>

          <p style="margin:20px 0 0;font-size:14px;color:#475569;line-height:1.6;">
            L'étudiant a confirmé sa participation. Vous pouvez le contacter pour préparer son arrivée.
          </p>

          <table cellpadding="0" cellspacing="0" style="margin-top:24px;">
            <tr>
              <td style="background:#2563eb;border-radius:8px;">
                <a href="{{ config('app.url') }}/postulation" style="display:inline-block;padding:12px 28px;color:#ffffff;font-size:14px;font-weight:600;text-decoration:none;">Voir les candidatures →</a>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <tr>
        <td style="border-top:1px solid #e2e8f0;padding:20px 40px;">
          <p style="margin:0;font-size:12px;color:#94a3b8;">Cet email a été envoyé automatiquement par CyStage. Merci de ne pas y répondre.</p>
        </td>
      </tr>

    </table>
  </td></tr>
</table>
</body>
</html>
