<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::unprepared("
        INSERT INTO `suppliers` (`id`, `name`, `alias`, `tax_id`, `email`, `phone`, `secondary_phone`, `website`, `contact_person`, `contact_email`, `contact_phone`, `address`, `city`, `state`, `zip_code`, `country`, `notes`, `created_at`, `updated_at`) VALUES
        ('1234567890123456789012345', 'Cemento Chistoso S.A.', 'Cemento', 'Z98765432', 'info@cementochistoso.com', '6315123456', '6315234567', 'www.cementochistoso.com', 'Jaime Jocoso', 'jaime@cementochistoso.com', '6315234567', 'Avenida Árida 123', 'Madrid', 'Madrid', '28002', 'España', 'Entrega en sacos de 25kg con chistes impresos', NOW(), NOW()),
        ('2345678901234567890123456', 'Madera Melodiosa S.L.', 'Madera', 'Y87654321', 'contacto@maderamellodiosa.es', '6315345678', '6315456789', 'www.maderamellodiosa.es', 'Marina Musical', 'marina@maderamellodiosa.es', '6315456789', 'Calle del Carpintero 45', 'Barcelona', 'Cataluña', '08002', 'España', 'Cada tabla viene con una nota musical', NOW(), NOW()),
        ('3456789012345678901234567', 'Tornillos Traviesos', 'Tornillos', 'X76543210', 'ventas@tornillostraviesos.com', '6315567890', '6315678901', 'www.tornillostraviesos.com', 'Tomás Travesura', 'tomas@tornillostraviesos.com', '6315678901', 'Plaza del Perforador 67', 'Valencia', 'Valencia', '46002', 'España', 'Envía tornillos con formas divertidas', NOW(), NOW()),
        ('4567890123456789012345678', 'Hierros Hilarantes', 'Hierros', 'W65432109', 'info@hierroshilarantes.es', '6315789012', '6315890123', 'www.hierroshilarantes.es', 'Hugo Humorista', 'hugo@hierroshilarantes.es', '6315890123', 'Bulevar de la Barra 12', 'Sevilla', 'Andalucía', '41002', 'España', 'Metal forjado por comediantes', NOW(), NOW()),
        ('5678901234567890123456789', 'Vidrios Vivaces', 'Vidrios', 'V54321098', 'contacto@vidriosvivaces.com', '6315901234', '6315012345', 'www.vidriosvivaces.com', 'Víctor Vivaracho', 'victor@vidriosvivaces.com', '6315012345', 'Travesía Transparente 34', 'Bilbao', 'País Vasco', '48002', 'España', 'Cristales que cambian de color con la temperatura', NOW(), NOW()),
        ('6789012345678901234567890', 'Pinturas Pícaras', 'Pinturas', 'U43210987', 'ventas@pinturaspícaras.es', '6316123456', '6316234567', 'www.pinturaspícaras.es', 'Paula Pícara', 'paula@pinturaspícaras.es', '6316234567', 'Callejón del Colorido 78', 'Zaragoza', 'Aragón', '50002', 'España', 'Botes que hacen ruidos graciosos al abrirlos', NOW(), NOW()),
        ('7890123456789012345678901', 'Herramientas Histriónicas', 'Herramientas', 'T32109876', 'info@herramientashistrionicas.com', '6316345678', '6316456789', 'www.herramientashistrionicas.com', 'Héctor Histrión', 'hector@herramientashistrionicas.com', '6316456789', 'Ronda del Reparador 56', 'Málaga', 'Andalucía', '29002', 'España', 'Martillos que suenan como bocinas', NOW(), NOW()),
        ('8901234567890123456789012', 'Cables Carcajeantes', 'Cables', 'S21098765', 'contacto@cablescarcajeantes.es', '6316567890', '6316678901', 'www.cablescarcajeantes.es', 'Carlos Carcajada', 'carlos@cablescarcajeantes.es', '6316678901', 'Paseo del Polo 90', 'Murcia', 'Murcia', '30002', 'España', 'Cables con fundas de colores neón', NOW(), NOW()),
        ('9012345678901234567890123', 'Aislantes Animados', 'Aislantes', 'R10987654', 'ventas@aislantesanimados.com', '6316789012', '6316890123', 'www.aislantesanimados.com', 'Ana Animada', 'ana@aislantesanimados.com', '6316890123', 'Vía del Vapor 23', 'Palma', 'Islas Baleares', '07002', 'España', 'Material que cambia de textura según el clima', NOW(), NOW()),
        ('0123456789012345678901234', 'Tuberías Teatrales', 'Tuberías', 'Q09876543', 'info@tuberiasteatrales.es', '6316901234', '6316012345', 'www.tuberiasteatrales.es', 'Teresa Teatral', 'teresa@tuberiasteatrales.es', '6316012345', 'Avenida del Agua 45', 'Las Palmas', 'Canarias', '35002', 'España', 'Cada metro de tubería incluye un chiste impreso', NOW(), NOW()),
        ('1122334455667788990011223', 'Azulejos Alegóricos', 'Azulejos', 'P98765432', 'contacto@azulejosalegoricos.com', '6317123456', '6317234567', 'www.azulejosalegoricos.com', 'Alberto Alegre', 'alberto@azulejosalegoricos.com', '6317234567', 'Plaza de la Porcelana 67', 'Alicante', 'Valencia', '03002', 'España', 'Diseños que cuentan historias divertidas', NOW(), NOW()),
        ('2233445566778899001122334', 'Impermeables Irónicos', 'Impermeables', 'O87654321', 'ventas@impermeablesironicos.es', '6317345678', '6317456789', 'www.impermeablesironicos.es', 'Irene Irónica', 'irene@impermeablesironicos.es', '6317456789', 'Callejón del Chaparrón 12', 'Córdoba', 'Andalucía', '14002', 'España', 'Material que repele agua con estilo y humor', NOW(), NOW()),
        ('3344556677889900112233445', 'Granito Grotesco', 'Granito', 'N76543210', 'info@granitogrotesco.com', '6317567890', '6317678901', 'www.granitogrotesco.com', 'Gonzalo Gracioso', 'gonzalo@granitogrotesco.com', '6317678901', 'Travesía de la Tosca 34', 'Valladolid', 'Castilla y León', '47002', 'España', 'Piedras con caras talladas', NOW(), NOW()),
        ('4455667788990011223344556', 'Yeso Yogui', 'Yeso', 'M65432109', 'contacto@yesoyogui.es', '6317789012', '6317890123', 'www.yesoyogui.es', 'Yolanda Yogui', 'yolanda@yesoyogui.es', '6317890123', 'Ronda del Revestimiento 56', 'Vigo', 'Galicia', '36002', 'España', 'Yeso que endurece haciendo posturas de yoga', NOW(), NOW()),
        ('5566778899001122334455667', 'Tejas Traviesas', 'Tejas', 'L54321098', 'ventas@tejastraviesas.com', '6317901234', '6317012345', 'www.tejastraviesas.com', 'Teo Travesura', 'teo@tejastraviesas.com', '6317012345', 'Bulevar del Barro 78', 'Gijón', 'Asturias', '33002', 'España', 'Tejas con formas de animales', NOW(), NOW());
    ");
    }
}
