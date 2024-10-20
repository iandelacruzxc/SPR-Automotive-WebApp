<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        DB::table('services')->insert([
            [
                'id' => 1,
                'name' => 'COLLISION REPAIR',
                'description' => "Our expert team specializes in collision repair, ensuring that every vehicle is restored to its original condition with precision and care. Whether it's a minor fender bender or significant collision damage, we use state-of-the-art equipment and techniques to repair and refurbish your vehicle. We prioritize safety and quality, ensuring that each repair meets industry standards and leaves your car looking and performing as good as new.\n\nWe keep you informed at every stage, ensuring transparency and confidence in our services. With a commitment to excellence, we strive to make the collision repair process as smooth and stress-free as possible.",
                'price' => 1500.00,
                'status' => 1,
                'delete_flag' => 0,
                'created_at' => '2024-10-09 00:50:31',
                'updated_at' => '2024-10-09 00:57:58',
            ],
            [
                'id' => 2,
                'name' => 'REPAINTING',
                'description' => "Our repainting services breathe new life into your vehicle, restoring its original luster or giving it a fresh, new look. We offer a variety of paint options and finishes, meticulously applied in our advanced spray booths. Our experienced painters match colors perfectly and apply the paint with precision, ensuring a flawless finish that protects your vehicle and enhances its aesthetic appeal.\n\nA high-quality paint job can prevent rust and corrosion, extending the lifespan of your vehicle's exterior. Whether you're looking to restore the factory finish or explore custom colors and designs, our team will work with you to achieve the perfect look.",
                'price' => 1500.00,
                'status' => 1,
                'delete_flag' => 0,
                'created_at' => '2024-10-09 00:51:57',
                'updated_at' => '2024-10-11 10:48:41',
            ],
            [
                'id' => 3,
                'name' => 'CERAMIC COATING',
                'description' => "Protect your car’s exterior with our top-notch ceramic coating services. This advanced coating provides a durable, long-lasting shield against environmental contaminants, UV rays, and minor scratches. It enhances your vehicle’s paint with a high-gloss finish that is easy to clean and maintain. Our ceramic coating not only preserves the beauty of your car but also adds value by prolonging the life of its exterior.\n\nOur ceramic coating process is thorough and meticulous, ensuring that every inch of your vehicle is covered and protected. We start with a detailed cleaning and paint correction to prepare the surface, followed by the application of the ceramic coating. The result is a stunning, mirror-like finish that offers superior protection.",
                'price' => 1500.00,
                'status' => 1,
                'delete_flag' => 0,
                'created_at' => '2024-10-09 00:54:29',
                'updated_at' => '2024-10-09 00:56:44',
            ],
            [
                'id' => 4,
                'name' => 'INSURANCE JOBS',
                'description' => "Our dedicated team is here to help you on your insurance claims. We work closely with insurance companies to ensure a seamless and hassle-free process for our clients. From initial estimates to final repairs, we handle all the details, providing transparent communication and high-quality service that meets and exceeds insurance standards.\n\nWe also offer support and guidance throughout the entire process, answering any questions you may have and keeping you informed every step of the way.",
                'price' => 1500.00,
                'status' => 1,
                'delete_flag' => 0,
                'created_at' => '2024-10-09 00:55:44',
                'updated_at' => '2024-10-09 00:55:44',
            ],
            [
                'id' => 5,
                'name' => 'RESTORATION',
                'description' => "Bring your car back to life with our comprehensive restoration services. We take pride in our meticulous attention to detail, from restoring parts to executing precise bodywork and paint jobs. Our restoration process is tailored to preserve the aesthetics of your vehicle while enhancing its performance. Our team of experts is skilled in engine rebuilds, electrical systems overhauls, and drivetrain restorations, ensuring that your vehicle runs as beautifully as it looks.",
                'price' => 1500.00,
                'status' => 1,
                'delete_flag' => 0,
                'created_at' => '2024-10-09 00:59:44',
                'updated_at' => '2024-10-09 00:59:44',
            ],
            [
                'id' => 6,
                'name' => 'ENGINE TROUBLESHOOTING',
                'description' => "Our engine troubleshooting services are designed to quickly and accurately identify and resolve engine issues. Whether your car is experiencing performance problems, unusual noises, or warning lights, we provide thorough repairs and maintenance to ensure your engine runs smoothly and efficiently, minimizing downtime and maximizing reliability.\n\nOur comprehensive approach to engine troubleshooting includes not only identifying and fixing the immediate issue but also addressing any underlying problems that could cause future failures. Our goal is to provide long-term solutions that enhance the performance and longevity of your vehicle.",
                'price' => 1500.00,
                'status' => 1,
                'delete_flag' => 0,
                'created_at' => '2024-10-09 01:00:55',
                'updated_at' => '2024-10-09 01:00:55',
            ],
            [
                'id' => 7,
                'name' => 'MAJOR AND MINOR REPAIR (MECHANICAL)',
                'description' => "From routine maintenance to complex mechanical issues, our skilled technicians handle all major and minor repairs with expertise and efficiency. We diagnose and fix problems ranging from brake and suspension issues to engine and transmission repairs. Using the latest diagnostic tools and high-quality parts, we ensure your vehicle runs smoothly and reliably, providing you with peace of mind on the road.\n\nWe understand the importance of timely repairs, which is why we offer fast turnaround times without compromising on quality. Our team is trained to work on a wide range of vehicle makes and models, ensuring that every repair is done right the first time.",
                'price' => 1500.00,
                'status' => 1,
                'delete_flag' => 0,
                'created_at' => '2024-10-09 01:02:03',
                'updated_at' => '2024-10-09 01:02:03',
            ],
            [
                'id' => 8,
                'name' => 'EXTERIOR AND INTERIOR DETAILING',
                'description' => "Our exterior and interior detailing services will make your car look fresher than ever. We go beyond a standard wash to meticulously clean, polish, and protect every surface of your vehicle. Using premium products and advanced techniques, we enhance both the exterior and interior, ensuring your car looks and feels like new.\n\nWe provide thorough paint correction, waxing and polishing, enhancing your vehicle's shine and protecting it from the elements. Our interior detailing services include deep cleaning, conditioning, and sanitizing, ensuring a fresh and comfortable driving environment.",
                'price' => 1500.00,
                'status' => 1,
                'delete_flag' => 0,
                'created_at' => '2024-10-09 01:03:41',
                'updated_at' => '2024-10-09 01:03:41',
            ],
            [
                'id' => 9,
                'name' => 'PMS',
                'description' => 'Other Service',
                'price' => 1500.00,
                'status' => 1,
                'delete_flag' => 0,
                'created_at' => '2024-10-09 01:04:37',
                'updated_at' => '2024-10-09 01:05:15',
            ],
            [
                'id' => 10,
                'name' => 'Car Air Conditioning Services',
                'description' => 'Other Service',
                'price' => 1500.00,
                'status' => 1,
                'delete_flag' => 0,
                'created_at' => '2024-10-09 01:05:00',
                'updated_at' => '2024-10-09 01:05:00',
            ],
            [
                'id' => 11,
                'name' => 'Customization',
                'description' => 'Other Service',
                'price' => 1500.00,
                'status' => 1,
                'delete_flag' => 0,
                'created_at' => '2024-10-09 01:05:35',
                'updated_at' => '2024-10-09 01:05:35',
            ],
        ]);
    }
}
