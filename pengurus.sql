CREATE DATABASE IF NOT EXISTS pengurus_pendidikan;
USE pengurus_pendidikan;

CREATE TABLE pengurus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_pengurus VARCHAR(100),
    jabatan VARCHAR(100),
    unit VARCHAR(100)
);

INSERT INTO pengurus (nama_pengurus, jabatan, unit) VALUES
('Ahmad Fauzi', 'Ketua Sub Pendidikan', 'Kecamatan A'),
('Siti Aminah', 'Sekretaris', 'Kecamatan B'),
('Dedi Kurniawan', 'Bendahara', 'Kecamatan C');
