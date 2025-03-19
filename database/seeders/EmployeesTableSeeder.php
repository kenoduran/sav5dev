<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::unprepared("
        INSERT INTO `employees` (`id`, `name`, `alias`, `employee_id`, `email`, `phone`, `secondary_phone`, `position`, `department`, `hire_date`, `salary`, `website`, `address`, `city`, `state`, `zip_code`, `country`, `notes`, `created_at`, `updated_at`) VALUES
        ('1234567890123456', 'Miguel Ángel Rodríguez Sánchez', 'Miguel', 'EMP001', 'miguel@empresa.com', '6318123456', '6318234567', 'Director General', 'Dirección', '2020-01-15', 65000.00, NULL, 'Calle Mayor 123', 'Madrid', 'Madrid', '28001', 'España', 'Fundador de la empresa', NOW(), NOW()),
        ('2345678901234567', 'Laura Fernández García', 'Laura', 'EMP002', 'laura@empresa.com', '6318345678', '6318456789', 'Directora Financiera', 'Finanzas', '2020-02-10', 58000.00, NULL, 'Avenida Principal 45', 'Madrid', 'Madrid', '28002', 'España', 'Experta en contabilidad y finanzas', NOW(), NOW()),
        ('3456789012345678', 'Carlos Martínez López', 'Carlos', 'EMP003', 'carlos@empresa.com', '6318567890', '6318678901', 'Jefe de Ventas', 'Comercial', '2020-03-05', 52000.00, NULL, 'Plaza Mayor 67', 'Barcelona', 'Cataluña', '08001', 'España', 'Excelente comunicador y negociador', NOW(), NOW()),
        ('4567890123456789', 'Ana Gómez Pérez', 'Ana', 'EMP004', 'ana@empresa.com', '6318789012', '6318890123', 'Responsable de Recursos Humanos', 'RRHH', '2020-04-20', 48000.00, NULL, 'Calle del Prado 12', 'Madrid', 'Madrid', '28003', 'España', 'Especialista en selección de personal', NOW(), NOW()),
        ('5678901234567890', 'Javier López Sánchez', 'Javier', 'EMP005', 'javier@empresa.com', '6318901234', '6318012345', 'Jefe de Almacén', 'Logística', '2020-05-15', 42000.00, NULL, 'Avenida Industrial 34', 'Valencia', 'Valencia', '46001', 'España', 'Gran capacidad organizativa', NOW(), NOW()),
        ('6789012345678901', 'Elena Torres Martín', 'Elena', 'EMP006', 'elena@empresa.com', '6319123456', '6319234567', 'Contable', 'Finanzas', '2020-06-10', 38000.00, NULL, 'Calle Nueva 56', 'Madrid', 'Madrid', '28004', 'España', 'Meticulosa y eficiente', NOW(), NOW()),
        ('7890123456789012', 'Pablo Ramírez Castro', 'Pablo', 'EMP007', 'pablo@empresa.com', '6319345678', '6319456789', 'Comercial', 'Comercial', '2020-07-05', 36000.00, 'www.pabloramirez.com', 'Plaza de España 78', 'Sevilla', 'Andalucía', '41001', 'España', 'Orientado a resultados', NOW(), NOW()),
        ('8901234567890123', 'Sofía García Rodríguez', 'Sofía', 'EMP008', 'sofia@empresa.com', '6319567890', '6319678901', 'Administrativa', 'Administración', '2020-08-20', 32000.00, NULL, 'Calle Ancha 90', 'Barcelona', 'Cataluña', '08002', 'España', 'Polivalente y resolutiva', NOW(), NOW()),
        ('9012345678901234', 'Daniel Hernández Gil', 'Daniel', 'EMP009', 'daniel@empresa.com', '6319789012', '6319890123', 'Técnico de Mantenimiento', 'Mantenimiento', '2020-09-15', 34000.00, NULL, 'Avenida del Parque 23', 'Madrid', 'Madrid', '28005', 'España', 'Habilidoso y eficaz', NOW(), NOW()),
        ('0123456789012345', 'María Jiménez Ruiz', 'María', 'EMP010', 'maria@empresa.com', '6319901234', '6319012345', 'Técnico de Calidad', 'Calidad', '2020-10-10', 36000.00, NULL, 'Calle del Río 45', 'Zaragoza', 'Aragón', '50001', 'España', 'Perfeccionista y detallista', NOW(), NOW()),
        ('0987654321098765', 'Roberto Díaz Moreno', 'Roberto', 'EMP011', 'roberto@empresa.com', '6310123456', '6310234567', 'Conductor', 'Logística', '2020-11-05', 30000.00, NULL, 'Plaza del Sol 67', 'Madrid', 'Madrid', '28006', 'España', 'Puntual y responsable', NOW(), NOW()),
        ('9876543210987654', 'Carmen Sanz Flores', 'Carmen', 'EMP012', 'carmen@empresa.com', '6310345678', '6310456789', 'Recepcionista', 'Administración', '2020-12-20', 28000.00, NULL, 'Calle Principal 89', 'Barcelona', 'Cataluña', '08003', 'España', 'Excelente atención al cliente', NOW(), NOW());
    ");
    }
}
