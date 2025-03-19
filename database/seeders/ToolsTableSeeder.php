<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ToolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::unprepared("
       INSERT INTO `tools` (`id`, `name`, `type`, `model`, `manufacturer`, `purchase_date`, `cost`, `serial_number`, `location`, `last_maintenance_date`, `next_maintenance_due`, `created_at`, `updated_at`) VALUES
        ('1234567890123456', 'Taladro percutor', 'Eléctrico', 'DW511', 'DeWalt', '2023-06-15', 299.99, 'DW511-78542369', 'Almacén principal', '2024-01-10', '2024-07-10', NOW(), NOW()),
        ('2345678901234567', 'Sierra circular', 'Eléctrico', 'CS1500', 'Makita', '2023-05-22', 249.50, 'MK-CS1500-45678', 'Obra Residencial Vista Norte', '2024-02-05', '2024-08-05', NOW(), NOW()),
        ('3456789012345678', 'Mezcladora de concreto', 'Motor a gasolina', 'CM90', 'Truper', '2022-11-30', 1200.00, 'TR-CM90-123456', 'Almacén secundario', '2024-01-20', '2024-04-20', NOW(), NOW()),
        ('4567890123456789', 'Martillo neumático', 'Neumático', 'JH40', 'Bosch', '2023-03-10', 850.75, 'BOSCH-JH40-987654', 'Obra Comercial Centro', '2024-02-15', '2024-05-15', NOW(), NOW()),
        ('5678901234567890', 'Nivel láser', 'Eléctrico', 'GLL 3-80', 'Bosch', '2023-07-05', 450.25, 'BOS-3380-456123', 'Oficina principal', '2024-01-05', '2024-07-05', NOW(), NOW()),
        ('6789012345678901', 'Andamio metálico', 'Manual', 'AND-200', 'Truper', '2022-09-18', 350.00, NULL, 'Almacén principal', '2023-12-10', '2024-06-10', NOW(), NOW()),
        ('7890123456789012', 'Compresor de aire', 'Eléctrico', 'CP1660', 'Campbell Hausfeld', '2023-02-28', 520.99, 'CH-16600-789456', 'Obra Industrial Este', '2024-02-28', '2024-08-28', NOW(), NOW()),
        ('8901234567890123', 'Generador eléctrico', 'Motor a gasolina', 'EU2200i', 'Honda', '2022-12-15', 1899.99, 'HON-2200-159753', 'Almacén secundario', '2024-01-15', '2024-04-15', NOW(), NOW()),
        ('9012345678901234', 'Pulidora de concreto', 'Eléctrico', 'PC7500', 'Hilti', '2023-08-10', 750.50, 'HIL-7500-852369', 'Obra Residencial Sur', '2024-02-10', '2024-05-10', NOW(), NOW()),
        ('0123456789012345', 'Escalera telescópica', 'Manual', 'ET450', 'Werner', '2023-04-20', 289.75, 'WER-450-987123', 'Almacén principal', '2023-10-20', '2024-04-20', NOW(), NOW()),
        ('1357924680123456', 'Soldadora eléctrica', 'Eléctrico', 'POWER MIG 210', 'Lincoln Electric', '2022-10-05', 1450.00, 'LE-210-741258', 'Taller de soldadura', '2024-01-05', '2024-04-05', NOW(), NOW()),
        ('2468013579246801', 'Pistola de clavos', 'Neumático', 'NV90AG', 'Hitachi', '2023-09-12', 325.50, 'HIT-90AG-123789', 'Obra Comercial Oeste', '2024-03-12', '2024-09-12', NOW(), NOW()),
        ('1593572468013579', 'Retroexcavadora mini', 'Diesel', 'EX17', 'Caterpillar', '2022-08-22', 35000.00, 'CAT-EX17-987654', 'Proyecto carretera norte', '2024-02-22', '2024-05-22', NOW(), NOW()),
        ('9517538642097531', 'Mesa de corte', 'Eléctrico', 'TC3700', 'Rubi', '2023-01-18', 899.99, 'RUB-3700-159357', 'Obra Residencial Este', '2024-01-18', '2024-07-18', NOW(), NOW()),
        ('7531598520147963', 'Vibrador de concreto', 'Eléctrico', 'VC2000', 'Sirl', '2023-11-05', 450.25, 'SIR-2000-753159', 'Obra Puente Municipal', '2024-02-05', '2024-05-05', NOW(), NOW()),
        ('9638527410369852', 'Gato hidráulico', 'Hidráulico', 'GH50', 'Truper', '2023-05-30', 220.00, 'TRU-50-963852', 'Almacén secundario', '2023-11-30', '2024-05-30', NOW(), NOW()),
        ('8520369741258963', 'Lijadora orbital', 'Eléctrico', 'DWE6421', 'DeWalt', '2023-07-25', 189.99, 'DW-6421-852963', 'Taller de carpintería', '2024-01-25', '2024-07-25', NOW(), NOW()),
        ('7418529630258741', 'Sierra de inglete', 'Eléctrico', 'DWS779', 'DeWalt', '2022-12-28', 599.50, 'DW-779-741852', 'Taller de carpintería', '2024-02-28', '2024-05-28', NOW(), NOW()),
        ('3698521470369852', 'Plataforma elevadora', 'Hidráulico', 'PL2000', 'JLG', '2022-07-10', 12500.00, 'JLG-2000-369852', 'Almacén principal', '2024-01-10', '2024-04-10', NOW(), NOW()),
        ('1472583690147258', 'Rotomartillo', 'Eléctrico', 'GBH 2-28', 'Bosch', '2023-10-15', 425.75, 'BOS-228-147258', 'Obra Edificio Central', '2024-03-15', '2024-06-15', NOW(), NOW());
    ");
    }
}
