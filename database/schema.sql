-- ═══════════════════════════════════════════════════════════════
--  EmpleoApp — Esquema de base de datos
--  Motor: MySQL 8+ / MariaDB 10.5+
-- ═══════════════════════════════════════════════════════════════

CREATE DATABASE IF NOT EXISTS empleo_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE empleo_db;

-- ── Tabla: empleos ──────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS empleos (
    id              VARCHAR(16)     NOT NULL,
    nombre          VARCHAR(150)    NOT NULL                        COMMENT 'Nombre del cargo',
    categoria       VARCHAR(50)     NOT NULL                        COMMENT 'Categoría: Tecnología, Salud, etc.',
    area_trabajo    VARCHAR(100)    NOT NULL                        COMMENT 'Área dentro de la empresa',
    empresa         VARCHAR(150)    NOT NULL                        COMMENT 'Nombre de la empresa',
    nivel           VARCHAR(30)     NOT NULL                        COMMENT 'Junior, Senior, Lead, etc.',
    sueldo          DECIMAL(15, 2)  NOT NULL DEFAULT 0.00           COMMENT 'Salario mensual en COP',
    funciones       TEXT            NOT NULL                        COMMENT 'Descripción de funciones',
    cargo_jefe      VARCHAR(150)    NOT NULL                        COMMENT 'Cargo del jefe directo',
    creado_en       DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    actualizado_en  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    INDEX idx_nombre    (nombre),
    INDEX idx_empresa   (empresa),
    INDEX idx_categoria (categoria),
    INDEX idx_nivel     (nivel)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Registros de ofertas de empleo';

-- ── Datos de ejemplo ────────────────────────────────────────────
INSERT INTO empleos (id, nombre, categoria, area_trabajo, empresa, nivel, sueldo, funciones, cargo_jefe)
VALUES
('a1b2c3d4e5f6a1b2', 'Desarrollador Backend PHP',     'Tecnología', 'Ingeniería de Software', 'TechCorp S.A.',      'Senior',      6500000,
 'Diseñar e implementar APIs REST.\nMantener y escalar microservicios.\nRevisar código y mentorizar al equipo junior.\nCollaborar con el equipo de producto.',
 'CTO'),

('b2c3d4e5f6a1b2c3', 'Analista Financiero Sr.',       'Finanzas',   'Contabilidad y Finanzas', 'Inversiones Andes',  'Semi-Senior', 4800000,
 'Elaborar informes financieros mensuales.\nAnalizar estados de cuenta y KPIs.\nApoyar la planeación presupuestal anual.\nPresentar hallazgos a gerencia.',
 'Director Financiero'),

('c3d4e5f6a1b2c3d4', 'Docente de Matemáticas',        'Educación',  'Académica',               'Colegio San Ignacio','Junior',       2800000,
 'Impartir clases de matemáticas grado 9-11.\nPlanear y evaluar actividades pedagógicas.\nAtender a padres de familia.\nParticipación en comités académicos.',
 'Rector'),

('d4e5f6a1b2c3d4e5', 'Médico General',                'Salud',      'Urgencias',               'Clínica Medellín',   'Junior',       5200000,
 'Atención de pacientes en urgencias.\nDiagnóstico y prescripción médica.\nCoordinación con especialistas.\nRegistro en historia clínica electrónica.',
 'Jefe de Urgencias'),

('e5f6a1b2c3d4e5f6', 'Gerente de Ventas',             'Comercio',   'Ventas y Marketing',      'Distribuidora Norte','Manager',      8500000,
 'Liderar el equipo comercial de 12 personas.\nDefinir estrategias de ventas por canal.\nNegociar contratos con clientes clave.\nReporte trimestral al CEO.',
 'CEO');
