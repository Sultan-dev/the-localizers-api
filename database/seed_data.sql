-- Localizer Database Seed Data
-- Run this after creating the tables

-- ============================================
-- Insert Admin User
-- ============================================
-- Email: admin@localizer.com
-- Password: password
INSERT INTO `users` (`name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
('Admin User', 'admin@localizer.com', '$2y$12$0Ss.vnw8ArYO.04AMiu2w.GgS0BVYQhfp.CkOUSpyH..CrV3BRLBC', 'admin', NOW(), NOW());

-- ============================================
-- Insert Sample Cards
-- ============================================
INSERT INTO `cards` (`title`, `subtitle`, `description`, `link`, `badge`, `preview_url`, `type`, `is_coming_soon`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
('خبير تقييم العروض', 'جهة حكومية', 'خبير متخصص في تقييم العروض للمنافسات وفق متطلبات المحتوى المحلي وأنظمة المنافسات والمشتريات الحكومية، ويقدم الدعم في تحديد آليات المحتوى المحلي المناسبة لكل عملية ومشتريات.', 'https://evaluation-expert.cycls.ai/', 'جهة حكومية', 'https://via.placeholder.com/400x200/EBFBF5/018755?text=Offer+Evaluation', 'government', 0, 1, 1, NOW(), NOW()),
('خبير القائمة الإلزامية', 'جهة حكومية', 'خبير متخصص في التحقق من المنتجات المدرجة ضمن القائمة الإلزامية، ومعالجة الاستثناءات وفق الآلية المعتمدة، مع تزويدك بنبذة شاملة عن المنتجات وطريقة تسليمها.', 'https://ml-expert.cycls.ai/', 'جهة حكومية', 'https://via.placeholder.com/400x200/EBFBF5/018755?text=Mandatory+List', 'government', 0, 2, 1, NOW(), NOW()),
('الخبير العام للمحتوي المحلي', 'جهة حكومية', 'خبير عام في المحتوى المحلي، يقدم إجابات دقيقة وشاملة عن جميع المتطلبات، اللوائح، الأرقام، والتشريعات المتعلقة بالمحتوى المحلي.', 'https://local-content-expert.cycls.ai/', 'جهة حكومية', 'https://via.placeholder.com/400x200/EBFBF5/018755?text=Chat+Interface', 'government', 0, 3, 1, NOW(), NOW()),
('خبير المصادر الوطنية', 'جهة حكومية', 'خبير متخصص في المصادر الوطنية والمحتوى المحلي', NULL, 'جهة حكومية', NULL, 'government', 1, 4, 1, NOW(), NOW()),
('خبير تضمين متطلبات المحتوى المحلي', 'جهة حكومية', 'خبير متخصص في تضمين متطلبات المحتوى المحلي في الوثائق والعقود', NULL, 'جهة حكومية', NULL, 'government', 1, 5, 1, NOW(), NOW()),
('خبير إضافي', 'جهة حكومية', 'خبير إضافي قيد التطوير', NULL, 'جهة حكومية', NULL, 'government', 1, 6, 1, NOW(), NOW());

-- ============================================
-- Insert Sample Reviews/Ratings
-- ============================================
INSERT INTO `legislations` (`name`, `email`, `rate`, `review`, `created_at`, `updated_at`) VALUES
('أحمد محمد', 'ahmed@example.com', 5, 'خدمة ممتازة وسريعة، أنصح الجميع بالاستفادة منها', NOW(), NOW()),
('فاطمة علي', 'fatima@example.com', 4, 'تجربة جيدة جداً، لكن يمكن تحسين بعض النقاط', NOW(), NOW()),
('محمد خالد', NULL, 5, 'رائع جداً، شكراً لكم على هذه الخدمة المميزة', NOW(), NOW()),
('سارة أحمد', 'sara@example.com', 3, 'جيد ولكن يحتاج إلى بعض التحسينات', NOW(), NOW());

