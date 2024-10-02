<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "harga";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil data dari database dengan filter
$filter_query = "SELECT * FROM produk WHERE 1=1"; // Memulai dengan kondisi valid

// Menambahkan filter kategori jika ada
if (isset($_GET['kategori']) && !empty($_GET['kategori'])) {
    $kategori = $conn->real_escape_string($_GET['kategori']);
    $filter_query .= " AND kategori_barang='$kategori'";
}

// Menambahkan pencarian jika ada
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $filter_query .= " AND (nama_barang LIKE '%$search%' OR kategori_barang LIKE '%$search%' OR barcode LIKE '%$search%')";
}

// Menambahkan sort jika ada (terapkan meskipun pencarian tidak ada)
if (isset($_GET['sort']) && !empty($_GET['sort'])) {
    $sort = $_GET['sort'];
    
    if ($sort == 'atoz') {
        $filter_query .= " ORDER BY nama_barang ASC"; // Mengurutkan dari A ke Z
    } elseif ($sort == 'ztoa') {
        $filter_query .= " ORDER BY nama_barang DESC"; // Mengurutkan dari Z ke A
    } elseif ($sort == 'lowprice') {
        $filter_query .= " ORDER BY harga ASC"; // Harga terendah ke tertinggi
    } elseif ($sort == 'highprice') {
        $filter_query .= " ORDER BY harga DESC"; // Harga tertinggi ke terendah
    }
}

// Debugging: Tampilkan query SQL yang dihasilkan
// echo $filter_query; // Uncomment untuk melihat query yang dihasilkan

$result = $conn->query($filter_query);

// Cek apakah query berhasil
if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price List</title>
    <link rel="stylesheet" href="1.css">
</head>
<body>

<!-- Bagian Header -->
<header>
    <div class="logo">
        <img src="logo.png" alt="Logo Toko" />
    </div>
    <div class="info-toko">
        <h1>PIKKAT</h1>
        <p>Alamat: Jl. Contoh Alamat No.1</p>
        <p>Telepon: 0812-3456-7890</p>
    </div>
</header>

<!-- Bagian Filter dan Pencarian -->
<div class="filter-section">
    <form method="GET" action="">
        <select name="kategori">
            <option value="">Semua Kategori</option>
            <option value="BATHROOM">Bathroom</option>
            <option value="BEEF DELI">BEEF DELI</option>
            <option value="BISCUIT">BISCUIT</option>
            <option value="BODY CARE">BODY CARE</option>
            <option value="BODY LOTION">BODY LOTION </option>
            <option value="BREAKFAST CEREAL">BREAKFAST CEREAL</option>
            <option value="BUMBU INSTANT">BUMBU INSTANT</option>
            <option value="BUMBU MASAK">BUMBU MASAK</option>
            <option value="BUMBU TRADISIONAL">BUMBU TRADISIONAL</option>
            <option value="CANDIES">CANDIES</option>
            <option value="CHEESE">CHEESE</option>
            <option value="CANNED SEAFOOD">CANNED SEAFOOD</option>
            <option value="CHEWING GUM">CHEWING GUM</option>
            <option value="CHICKEN DELI">CHICKEN DELI</option>
            <option value="CHILLED BUTTER & MARGARINE">CHILLED BUTTER & MARGARINE</option>
            <option value="BISCUIT">BISCUIT</option>
            <option value="CHOCOLATE">CHOCOLATE</option>
            <option value="COFFEE">COFFEE</option>
            <option value="COOKIES">COOKIES</option>
            <option value="COSMETIC">COSMETIC</option>
            <option value="CRAKERS">CRACKERS</option>
            <option value="DEODORANT & COLOGNE">DEODORANT & COLOGNE</option>
            <option value="DETERGENT">DETERGENT</option>
            <option value="DRINKIG WATER">DRINKING WATER</option>
            <option value="FACIAL TISSUE">FACIAL TISSUE</option>
            <option value="FLOOR">FLOOR</option>
            <option value="FOOD TISSUE">FOOD TISSUE</option>
            <option value="BEEF DELI">BEEF DELI</option>
            <option value="BISCUIT">BISCUIT</option>
            <option value="FROZEN PROCESSED FOOD">FROZEN PROCESSED FOOD</option>
            <option value="GLASS">GLASS </option>
            <option value="HAIR CONDITIONER & CREAMBATH">HAIR CONDITIONER & CREAMBATH</option>
            <option value="HAIR VITAMIN">HAIR VITAMIN</option>
            <option value="HAND SOAP">HAND SOAP</option>
            <option value="ICE CREAM">ICE CREAM</option>
            <option value="ICE STICK">ICE STICK</option>
            <option value="CHEESE">CHEESE</option>
            <option value="INSTANT COFFEE">INSTANT COFFEE</option>
            <option value="JELLY">JELLY</option>
            <option value="JUICE">JUICE</option>
            <option value="KECAP">KECAP</option>
            <option value="KITCHEN">KITCHEN</option>
            <option value="LAUNDRY TREATMENT">LAUNDRY TREATMENT</option>
            <option value="LIQUID">LIQUID</option>
            <option value="MODERN SNACK">MODERN SNACK</option>
            <option value="MOUTH WASH, SPRAY & FLOSS">MOUTH WASH, SPRAY & FLOSS</option>
            <option value="NOODLE">NOODLE</option>
            <option value="NUTS & KWACI">NUTS & KWACI</option>
            <option value="OBAT DALAM">OBAT DALAM</option>
            <option value="OBAT LUAR">OBAT LUAR</option>
            <option value="OTHER">OTHER</option>
            <option value="PALM OIL">PALM OIL</option>
            <option value="PASTA">PASTA</option>
            <option value="PERSONAL CARE">PERSONAL CARE</option>
            <option value="PORRIDGE">PORRIDGE</option>
            <option value="POWDER BEVERAGES">POWDER BEVERAGES</option>
            <option value="RICE">RICE</option>
            <option value="RTD TEA & COFFEE">RTD TEA & COFFEE</option>
            <option value="SAMBAL">SAMBAL</option>
            <option value="SANDWICH">SANDWICH</option>
            <option value="BUMBU TRADISIONAL">BUMBU TRADISIONAL</option>
            <option value="SANITIZER">SANITIZER</option>
            <option value="CHEESE">CHEESE</option>
            <option value="SHAMPOO">SHAMPOO</option>
            <option value="SOFT DRINK">SOFT DRINK</option>
            <option value="SPICES">SPICES</option>
            <option value="SUGAR">SUGAR</option>
            <option value="TEH">TEH</option>
            <option value="TEPUNG">TEPUNG</option>
            <option value="TOILET TISSUE">TOILET TISSUE</option>
            <option value="TOMATO SAUCE">TOMATO SAUCE</option>
            <option value="TONIC DRINK">TONIC DRINK</option>
            <option value="TOOTH BRUSH">TOOTH BRUSH</option>
            <option value="TOOTH BRUSH">TOOTH PASTE</option>
            <option value="TREATMENT SOAP">TREATMENT SOAP</option>
            <option value="VERMICELLI">VERMICELLI</option>
            <option value="VITAMIN & SUPPLEMENT">VITAMIN & SUPPLEMENT</option>
            <option value="WAFER">WAFER</option>
            <option value="WET TISSUE">WET TISSUE</option>
            <option value="WRITING & OFFICE UTENSIL">WRITING & OFFICE UTENSIL</option>
            <option value="YOGHURT">YOGHURT</option>
            <!-- Tambahkan kategori lain sesuai kebutuhan -->
        </select>
        <select name="sort">
            <option value="">Urutkan Berdasarkan</option>
            <option value="atoz">A to Z</option>
            <option value="ztoa">Z to A</option>
            <option value="lowprice">Harga Terendah</option>
            <option value="highprice">Harga Tertinggi</option>
        </select>
        <input type="text" name="search" placeholder="Cari Produk" value="<?php echo isset($search) ? htmlspecialchars($search) : ''; ?>">
        <button type="submit">Filter</button>
    </form>
</div>

<!-- Bagian Tabel Produk -->
<table>
    <thead>
        <tr>
            <th>Barcode</th>
            <th>Gambar</th>
            <th>Kategori</th>
            <th>Nama Produk</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["barcode"]) . "</td>";
                echo '<td><img src="uploads/' . htmlspecialchars($row['gambar']) . '" alt="' . htmlspecialchars($row['nama_barang']) . '" /></td>';
                echo "<td>" . htmlspecialchars($row["kategori_barang"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["nama_barang"]) . "</td>";
                echo "<td>Rp " . number_format($row["harga"], 0, ',', '.') . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='notifikasi'>Barang tidak ditemukan. Silakan coba kata kunci lain.</td></tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>
