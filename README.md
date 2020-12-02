HEADSET BALI
Sales Data Management Application (Headset Bali)

Database : MySQL
Backend : PHP Native
Frontend : Bootstrap 4

FEATURE :
1. Overview (view annual, monthly, daily sales data)
2. Penjualan (add sales history)
3. Pembelian (add capital purchase data)
4. Data Modal (view capital data, total profit per capital)
5. Data Stok (view stock data, you can look at the items that sold the most or had the most profits)

DATABASE STRUCTURE (import headset-bali.sql to mysql) :
1. table data_barang
    - idBarang int (Auto Increment, Primary Key)
    - namaBarang char
    - totalStok int
    - totalLaku int
2. table modal
    - idModal int (A.I, P.K)
    - tanggalPembelian date
    - totalModal int
    - ongkir int
    - totalBarang int
    - status int
    - totalPenjualan int
3. table stok
    - idStok int (A.I, P.K)
    - idModal int
    - idBarang int
    - hargaModal int
    - hargaJual int
    - status int
    - tanggalTerjual date
