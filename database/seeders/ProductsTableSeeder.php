<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::unprepared("
        INSERT INTO `products` (`id`, `code`, `pic`, `short_description`, `long_description`, `brand`, `family`, `price1`, `price2`, `price3`, `cost`, `min_stock`, `max_stock`, `created_at`, `updated_at`) VALUES
        ('1111222233334444', 'CEM-001', NULL, 'Cemento Portland 25kg', 'Cemento Portland de alta resistencia para construcción general. Saco de 25kg.', 'ConstruMax', 'Cementos', 8.95, 8.50, 8.00, 6.75, 20, 100, NOW(), NOW()),
        ('2222333344445555', 'CEM-002', NULL, 'Cemento Blanco 20kg', 'Cemento blanco especial para acabados decorativos. Saco de 20kg.', 'ConstruMax', 'Cementos', 12.50, 11.95, 11.50, 9.25, 15, 80, NOW(), NOW()),
        ('3333444455556666', 'CEM-003', NULL, 'Mortero Rápido 15kg', 'Mortero de fraguado rápido para reparaciones urgentes. Saco de 15kg.', 'RapidMix', 'Cementos', 14.75, 14.20, 13.80, 10.50, 10, 60, NOW(), NOW()),
        ('4444555566667777', 'CEM-004', NULL, 'Cemento Cola Flexible 20kg', 'Cemento cola flexible para colocación de azulejos y gres. Saco de 20kg.', 'AzuFix', 'Cementos', 18.95, 18.40, 17.90, 14.25, 15, 75, NOW(), NOW()),
        ('5555666677778888', 'CEM-005', NULL, 'Mortero Impermeable 25kg', 'Mortero con propiedades impermeabilizantes para zonas húmedas. Saco de 25kg.', 'HydroBlock', 'Cementos', 22.50, 21.75, 21.00, 16.80, 10, 60, NOW(), NOW()),
        ('6666777788889999', 'LAD-001', NULL, 'Ladrillo Hueco Doble', 'Ladrillo cerámico hueco doble de 24x11.5x7cm. Paquete de 10 unidades.', 'CeramicPro', 'Ladrillos', 7.25, 6.95, 6.65, 5.40, 30, 150, NOW(), NOW()),
        ('7777888899990000', 'LAD-002', NULL, 'Ladrillo Macizo Rojo', 'Ladrillo macizo caravista de color rojo. 24x11.5x5cm. Paquete de 10 unidades.', 'CeramicPro', 'Ladrillos', 9.80, 9.40, 9.10, 7.25, 25, 125, NOW(), NOW()),
        ('8888999900001111', 'LAD-003', NULL, 'Ladrillo Refractario', 'Ladrillo refractario para chimeneas y hornos. 22x11x5cm. Paquete de 8 unidades.', 'FireBlock', 'Ladrillos', 18.50, 17.95, 17.50, 13.75, 15, 75, NOW(), NOW()),
        ('9999000011112222', 'MAD-001', NULL, 'Tablero OSB 10mm', 'Tablero OSB de 10mm de espesor. Medidas: 244x122cm.', 'MaderaPro', 'Maderas', 24.95, 24.25, 23.75, 18.50, 20, 100, NOW(), NOW()),
        ('0000111122223333', 'MAD-002', NULL, 'Tablero Contrachapado 15mm', 'Tablero contrachapado de 15mm de espesor. Medidas: 244x122cm.', 'MaderaPro', 'Maderas', 32.50, 31.75, 31.00, 24.00, 15, 75, NOW(), NOW()),
        ('1212343456567878', 'MAD-003', NULL, 'Listón Pino 5x5cm', 'Listón de pino cepillado de 5x5cm. Longitud: 240cm.', 'MaderaPro', 'Maderas', 8.75, 8.40, 8.00, 6.50, 30, 150, NOW(), NOW()),
        ('2323454567678989', 'MAD-004', NULL, 'Tablero Melamina Blanco', 'Tablero de melamina color blanco de 16mm. Medidas: 244x122cm.', 'MelaDecor', 'Maderas', 28.95, 28.25, 27.75, 21.50, 18, 90, NOW(), NOW()),
        ('3434565678789090', 'HER-001', NULL, 'Martillo de Carpintero', 'Martillo de carpintero con mango ergonómico. Peso: 450g.', 'ToolMaster', 'Herramientas', 15.95, 15.50, 15.00, 11.75, 10, 50, NOW(), NOW()),
        ('4545676789890101', 'HER-002', NULL, 'Destornillador Set 6 piezas', 'Set de 6 destornilladores de precisión con diferentes puntas.', 'ToolMaster', 'Herramientas', 24.50, 23.95, 23.50, 18.25, 8, 40, NOW(), NOW()),
        ('5656787890901212', 'HER-003', NULL, 'Taladro Percutor 800W', 'Taladro percutor potente con 800W y portabrocas de 13mm.', 'PowerDrill', 'Herramientas', 89.95, 87.50, 85.00, 67.00, 5, 25, NOW(), NOW()),
        ('6767898901012323', 'HER-004', NULL, 'Sierra Circular 1200W', 'Sierra circular con potencia de 1200W y disco de 185mm.', 'PowerCut', 'Herramientas', 125.00, 121.50, 118.00, 93.50, 4, 20, NOW(), NOW()),
        ('7878909012123434', 'HER-005', NULL, 'Amoladora Angular 750W', 'Amoladora angular con motor de 750W y disco de 115mm.', 'PowerCut', 'Herramientas', 79.95, 77.95, 75.95, 59.50, 6, 30, NOW(), NOW()),
        ('8989010123234545', 'HER-006', NULL, 'Nivel Profesional 60cm', 'Nivel profesional de aluminio con burbuja triple. Longitud: 60cm.', 'ToolMaster', 'Herramientas', 22.50, 21.95, 21.50, 16.75, 12, 60, NOW(), NOW()),
        ('9090121234345656', 'HER-007', NULL, 'Pistola Silicona', 'Pistola aplicadora de silicona para cartuchos estándar.', 'SealPro', 'Herramientas', 8.95, 8.65, 8.35, 6.65, 15, 75, NOW(), NOW()),
        ('0101232345456767', 'PIN-001', NULL, 'Pintura Plástica Blanca 15L', 'Pintura plástica mate blanca para interior. Bote de 15 litros.', 'ColorPlus', 'Pinturas', 45.95, 44.50, 43.25, 34.00, 8, 40, NOW(), NOW()),
        ('1234567890123456', 'PIN-002', NULL, 'Pintura Exterior Fachadas 10L', 'Pintura acrílica para fachadas con protección UV. Bote de 10 litros.', 'ColorPlus', 'Pinturas', 65.50, 63.95, 62.50, 48.75, 6, 30, NOW(), NOW()),
        ('2345678901234567', 'PIN-003', NULL, 'Esmalte Sintético 5L', 'Esmalte sintético brillante multiusos. Bote de 5 litros.', 'BrilloPro', 'Pinturas', 38.95, 37.75, 36.95, 28.95, 10, 50, NOW(), NOW()),
        ('3456789012345678', 'PIN-004', NULL, 'Imprimación Multiusos 4L', 'Imprimación selladora para múltiples superficies. Bote de 4 litros.', 'SealPro', 'Pinturas', 29.95, 29.25, 28.75, 22.50, 12, 60, NOW(), NOW()),
        ('4567890123456789', 'PIN-005', NULL, 'Barniz Madera Interior 2.5L', 'Barniz transparente para madera de interior. Bote de 2.5 litros.', 'WoodProtect', 'Pinturas', 24.50, 23.95, 23.50, 18.25, 15, 75, NOW(), NOW()),
        ('5678901234567890', 'AIS-001', NULL, 'Panel Aislante Lana Roca 60mm', 'Panel aislante térmico y acústico de lana de roca. 120x60cm, espesor 60mm.', 'ThermoBlock', 'Aislantes', 18.95, 18.40, 17.95, 14.25, 20, 100, NOW(), NOW()),
        ('6789012345678901', 'AIS-002', NULL, 'Poliestireno Expandido 40mm', 'Plancha de poliestireno expandido (EPS) de 40mm. 100x50cm.', 'ThermoBlock', 'Aislantes', 9.25, 8.95, 8.75, 6.95, 25, 125, NOW(), NOW()),
        ('7890123456789012', 'AIS-003', NULL, 'Aislante Reflectivo 10m²', 'Aislante térmico reflectivo multicapa. Rollo de 10m².', 'ReflexHeat', 'Aislantes', 35.50, 34.75, 33.95, 26.50, 10, 50, NOW(), NOW()),
        ('8901234567890123', 'AIS-004', NULL, 'Espuma Poliuretano 750ml', 'Espuma de poliuretano expansiva para sellar y fijar. Bote de 750ml.', 'SealPro', 'Aislantes', 11.95, 11.60, 11.25, 8.95, 20, 100, NOW(), NOW()),
        ('9012345678901234', 'IMB-001', NULL, 'Tela Asfáltica 10m²', 'Tela asfáltica impermeabilizante. Rollo de 10m².', 'WaterBlock', 'Impermeabilizantes', 42.50, 41.25, 40.00, 31.75, 8, 40, NOW(), NOW()),
        ('9876543210987654', 'IMB-002', NULL, 'Impermeabilizante Líquido 5kg', 'Impermeabilizante líquido de caucho para terrazas. Bote de 5kg.', 'WaterBlock', 'Impermeabilizantes', 55.95, 54.50, 53.00, 41.95, 6, 30, NOW(), NOW()),
        ('8765432109876543', 'IMB-003', NULL, 'Sellador Silicona 280ml', 'Sellador de silicona transparente para baños y cocinas. Cartucho de 280ml.', 'SealPro', 'Impermeabilizantes', 7.95, 7.65, 7.35, 5.95, 30, 150, NOW(), NOW()),
        ('7654321098765432', 'PYA-001', NULL, 'Placa Yeso Laminado 13mm', 'Placa de yeso laminado estándar de 13mm. 200x120cm.', 'DryWall', 'Yeso y Pladur', 12.50, 12.00, 11.75, 9.25, 25, 125, NOW(), NOW()),
        ('6543210987654321', 'PYA-002', NULL, 'Placa Yeso Hidrófuga 15mm', 'Placa de yeso laminado resistente al agua de 15mm. 200x120cm.', 'DryWall', 'Yeso y Pladur', 18.95, 18.40, 17.95, 14.25, 20, 100, NOW(), NOW()),
        ('5432109876543210', 'PYA-003', NULL, 'Pasta Juntas 5kg', 'Pasta para juntas de placas de yeso laminado. Bote de 5kg.', 'DryWall', 'Yeso y Pladur', 9.95, 9.65, 9.35, 7.45, 15, 75, NOW(), NOW()),
        ('4321098765432109', 'PYA-004', NULL, 'Perfil Metálico 3m', 'Perfil metálico para estructura de pladur. Longitud: 3m.', 'DryWall', 'Yeso y Pladur', 7.50, 7.25, 7.00, 5.60, 30, 150, NOW(), NOW()),
        ('3210987654321098', 'SAN-001', NULL, 'Inodoro Completo', 'Inodoro de porcelana con cisterna y mecanismos incluidos.', 'BañoPlus', 'Sanitarios', 149.95, 145.50, 142.00, 112.00, 5, 25, NOW(), NOW()),
        ('2109876543210987', 'SAN-002', NULL, 'Lavabo Pedestal', 'Lavabo de porcelana con pedestal incluido.', 'BañoPlus', 'Sanitarios', 89.95, 87.50, 85.00, 67.00, 6, 30, NOW(), NOW()),
        ('1098765432109876', 'SAN-003', NULL, 'Plato Ducha 80x80cm', 'Plato de ducha acrílico cuadrado. Medidas: 80x80cm.', 'ShowerTech', 'Sanitarios', 125.00, 121.50, 118.00, 93.50, 4, 20, NOW(), NOW()),
        ('1122334455667788', 'SAN-004', NULL, 'Grifo Lavabo Monomando', 'Grifo monomando para lavabo con acabado cromado.', 'AquaStyle', 'Sanitarios', 65.50, 63.95, 62.50, 48.75, 8, 40, NOW(), NOW()),
        ('2233445566778899', 'SAN-005', NULL, 'Mampara Ducha 80cm', 'Mampara de ducha con cristal templado transparente. Ancho: 80cm.', 'ShowerTech', 'Sanitarios', 195.00, 189.95, 184.95, 145.50, 3, 15, NOW(), NOW()),
        ('3344556677889900', 'PAV-001', NULL, 'Baldosa Cerámica 45x45cm', 'Baldosa cerámica para interior. Pack de 1m² (5 piezas). 45x45cm.', 'CeramicStyle', 'Pavimentos', 22.95, 22.25, 21.75, 17.00, 15, 75, NOW(), NOW()),
        ('4455667788990011', 'PAV-002', NULL, 'Gres Porcelánico 60x60cm', 'Gres porcelánico imitación madera. Pack de 1m² (3 piezas). 60x60cm.', 'CeramicStyle', 'Pavimentos', 32.95, 31.95, 31.00, 24.50, 12, 60, NOW(), NOW()),
        ('5566778899001122', 'PAV-003', NULL, 'Tarima Flotante AC4', 'Tarima flotante laminada AC4. Pack de 2,5m² (10 lamas). Imitación roble.', 'WoodFloor', 'Pavimentos', 45.50, 44.25, 43.00, 33.95, 10, 50, NOW(), NOW()),
        ('6677889900112233', 'PAV-004', NULL, 'Rodapié PVC Blanco', 'Rodapié de PVC color blanco. Pack de 5 unidades. 240x7cm.', 'WoodFloor', 'Pavimentos', 19.95, 19.40, 18.95, 14.95, 18, 90, NOW(), NOW()),
        ('7788990011223344', 'PAV-005', NULL, 'Perfil Transición Aluminio', 'Perfil de transición entre pavimentos. Longitud: 93cm.', 'FloorTech', 'Pavimentos', 15.50, 14.95, 14.50, 11.50, 20, 100, NOW(), NOW()),
        ('8899001122334455', 'FER-001', NULL, 'Cerradura Puerta', 'Cerradura completa para puerta interior con manillas incluidas.', 'SecureLock', 'Ferretería', 42.95, 41.75, 40.95, 32.00, 10, 50, NOW(), NOW()),
        ('9900112233445566', 'FER-002', NULL, 'Bisagra Pack 3 unidades', 'Pack de 3 bisagras de acero para puertas.', 'SecureLock', 'Ferretería', 8.95, 8.65, 8.35, 6.65, 25, 125, NOW(), NOW()),
        ('0011223344556677', 'FER-003', NULL, 'Tornillos Autorroscantes 100 uds', 'Caja de 100 tornillos autorroscantes para madera 4x40mm.', 'FixPro', 'Ferretería', 7.50, 7.25, 7.00, 5.60, 30, 150, NOW(), NOW()),
        ('1133557799113355', 'FER-004', NULL, 'Taco Expansivo 50 uds', 'Bolsa de 50 tacos de expansión 8x40mm.', 'FixPro', 'Ferretería', 9.95, 9.65, 9.35, 7.45, 25, 125, NOW(), NOW()),
        ('2244668800224466', 'FER-005', NULL, 'Cadena Galvanizada 2m', 'Cadena de acero galvanizado. Longitud: 2m.', 'MetalPro', 'Ferretería', 14.50, 14.00, 13.50, 10.75, 15, 75, NOW(), NOW()),
        ('3355779911335577', 'ELE-001', NULL, 'Cable Eléctrico 10m', 'Cable eléctrico flexible 3x1.5mm². Rollo de 10m.', 'ElectroWire', 'Material Eléctrico', 18.95, 18.40, 17.95, 14.25, 20, 100, NOW(), NOW()),
        ('4466880022446688', 'ELE-002', NULL, 'Caja Mecanismos Empotrar', 'Caja de mecanismos para empotrar en pared. Pack de 5 unidades.', 'ElectroPro', 'Material Eléctrico', 7.95, 7.65, 7.35, 5.95, 25, 125, NOW(), NOW()),
        ('5577991133557799', 'ELE-003', NULL, 'Enchufe Doble', 'Enchufe doble con embellecedor incluido.', 'ElectroPro', 'Material Eléctrico', 12.50, 12.00, 11.75, 9.25, 18, 90, NOW(), NOW()),
        ('6688002244668800', 'ELE-004', NULL, 'Interruptor Simple', 'Interruptor simple con embellecedor incluido.', 'ElectroPro', 'Material Eléctrico', 9.95, 9.65, 9.35, 7.45, 20, 100, NOW(), NOW()),
        ('7799113355779911', 'ELE-005', NULL, 'Regleta Conexión 12 Terminales', 'Regleta de conexión eléctrica con 12 terminales.', 'ElectroWire', 'Material Eléctrico', 5.50, 5.30, 5.10, 4.10, 30, 150, NOW(), NOW()),
        ('8800224466880022', 'FNT-001', NULL, 'Tubo PVC 2m 40mm', 'Tubo de PVC para fontanería. Diámetro: 40mm. Longitud: 2m.', 'HydroPipe', 'Fontanería', 11.95, 11.60, 11.25, 8.95, 25, 125, NOW(), NOW()),
        ('9911335577991133', 'FNT-002', NULL, 'Codo PVC 90° 40mm', 'Codo de PVC 90 grados para tubería de 40mm. Pack de 5 unidades.', 'HydroPipe', 'Fontanería', 8.95, 8.65, 8.35, 6.65, 20, 100, NOW(), NOW()),
        ('0022446688002244', 'FNT-003', NULL, 'Sifón Lavabo Extensible', 'Sifón extensible para lavabo con válvula incluida.', 'WaterTech', 'Fontanería', 15.95, 15.50, 15.00, 11.75, 15, 75, NOW(), NOW()),
        ('1133557722446688', 'FNT-004', NULL, 'Llave de Paso 3/4', 'Llave de paso para tubería de 3/4 pulgadas.', 'WaterTech', 'Fontanería', 18.50, 17.95, 17.50, 13.75, 12, 60, NOW(), NOW()),
        ('2244668833557799', 'FNT-005', NULL, 'Flexo Ducha 1.5m', 'Flexo para ducha reforzado. Longitud: 1.5m.', 'ShowerTech', 'Fontanería', 12.95, 12.50, 12.00, 9.65, 18, 90, NOW(), NOW())
    ");
    }
}
