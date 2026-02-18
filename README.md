<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## About
Coding test untuk melamar prosisi Programmer di PT. Garuda Cyber Indonesia<br>
Stack: Laravel 11, PHP 8.3, MySql DB<br>
Arsitektur: Controller -> Service -> Model<br>
Mail: mailtrap.io<br><br>

## API Endpoint
- Public Route
<table>
        <tr>
            <th>METHOD</th>
            <th>END POINT</th>
            <th>KET</th>
        </tr>
    <tr>
        <td>POST</td>
        <td>v1/register</td>
        <td>Untuk register user</td>
    </tr>
    <tr>
        <td>POST</td>
        <td>v1/login</td>
        <td>Untuk Login</td>
    </tr>
</table>

- Auth Route
    1. Public Auth Route
    <table>
        <tr>
            <th>METHOD</th>
            <th>END POINT</th>
            <th>KET</th>
        </tr>
        <tr>
            <td>POST</td>
            <td>v1/logout</td>
            <td>Untuk logout dan revoke token aktif</td>
        </tr>
        <tr>
            <td>GET</td>
            <td>v1/courses</td>
            <td>Menampilkan semua list Course</td>
        </tr>
        <tr>
            <td>GET</td>
            <td>v1//discussions/course/{idCourse}</td>
            <td>Menampilkan list discussion berdasarkan Course yang dipilih</td>
        </tr>
        <tr>
            <td>POST</td>
            <td>v1/discussion</td>
            <td>Membuat diskusi baru berdasarkan Course</td>
        </tr>
    </table>

    2. Role Dosen Route
  <table>
      <tr>
            <th>METHOD</th>
            <th>END POINT</th>
            <th>KET</th>
        </tr>
      <tr>
          <td>POST</td>
          <td>v1/courses</td>
          <td>Untuk menambahkan Course berdasarkan akun dosen yang login</td>
      </tr>
      <tr>
          <td>PUT</td>
          <td>v1/course/{id}</td>
          <td>Untuk memperbaharui Course</td>
      </tr>
      <tr>
          <td>DELETE</td>
          <td>v1/course/{id}</td>
          <td>Untuk menghapus course (soft delete)</td>
      </tr>
      <tr>
          <td>POST</td>
          <td>v1/materials</td>
          <td>Untuk menambahkan materi di course tertentu</td>
      </tr>
      <tr>
          <td>GET</td>
          <td>v1/course/{courseId}/assignment</td>
          <td>Untuk menampilkan list Tugas/Assignments di course yang dipilih</td>
      </tr>
      <tr>
          <td>POST</td>
          <td>v1/assignments</td>
          <td>Untuk menambahkan Tugas/Assignments di course yang dipilih</td>
      </tr>
      <tr>
          <td>GET</td>
          <td>v1/submissions/{id}</td>
          <td>Download Tugas mahasiswa yang diupload</td>
      </tr>
      <tr>
          <td>POST</td>
          <td>v1/submissions/{id}/score</td>
          <td>Memberi nilai pada Tugas mahasiswa</td>
      </tr>
  </table>

  3. Role Mahasiswa Route
  <table>
      <tr>
            <th>METHOD</th>
            <th>END POINT</th>
            <th>KET</th>
        </tr>
      <tr>
          <td>GET</td>
          <td>v1/courses/student</td>
          <td>Menampilkan list Course yang diikuti oleh mahasiswa bersangkutan</td>
      </tr>
      <tr>
          <td>POST</td>
          <td>v1/courses/{id}/enroll</td>
          <td>Mendaftar ke Course yang akan diikuti</td>
      </tr>
      <tr>
          <td>GET</td>
          <td>v1/materials/{id}/download</td>
          <td>Download materi kuliah yang dipilih</td>
      </tr>
      <tr>
          <td>POST</td>
          <td>v1/submissions</td>
          <td>Upload tugas berdasarkan assignment yang dipilih</td>
      </tr>
  </table>



