<h2>Tugas Baru {{ $assignment->course->name }}</h2>

<p><strong>Judul:</strong> {{ $assignment->title }}</p>

<p><strong>Deskripsi:</strong> {{ $assignment->description }}</p>

<p>
<strong>Deadline:</strong>
{{ $assignment->deadline->format('d M Y') }}
Jam: {{ $assignment->deadline->format('H:i') }}
</p>