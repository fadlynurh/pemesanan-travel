<h2>Invoice #{{ $booking->id }}</h2>

<p>Nama: {{ $booking->user->name }}</p>
<p>Destinasi: {{ $booking->travel->destination }}</p>
<p>Tanggal Berangkat: {{ $booking->travel->departure_at }}</p>
<p>Jumlah Kursi: {{ $booking->quantity }}</p>
<p>Total Harga: Rp {{ number_format($booking->total_price) }}</p>

<p>Status Pembayaran: <strong>{{ $booking->status }}</strong></p>

<p>Terima kasih sudah memesan travel bersama kami.</p>
