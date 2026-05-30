<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; color: #1f2937; padding: 24px;">
<h2 style="color: #92400e;">Nova registracija — TK Tolmin</h2>
<p>Prispela je nova registracijska zahteva:</p>
<ul>
    <li><strong>Ime:</strong> {{ $user->name }}</li>
    <li><strong>E-mail:</strong> {{ $user->email }}</li>
    <li><strong>Izbrani igralec:</strong> {{ $user->player?->p_name ?? 'Brez' }}</li>
    <li><strong>Čas:</strong> {{ $user->created_at->format('d. m. Y H:i') }}</li>
</ul>
<p>Prijavite se v admin ploščo in odobrite ali zavrnite registracijo.</p>
</body>
</html>
