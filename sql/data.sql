--
-- Copyright (C) 2013 Jean-François Ferry <jfefe@aternatik.fr>
--
-- This program is free software: you can redistribute it and/or modify
-- it under the terms of the GNU General Public License as published by
-- the Free Software Foundation, either version 3 of the License, or
-- (at your option) any later version.
--
-- This program is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details.
--
-- You should have received a copy of the GNU General Public License
-- along with this program.  If not, see <http://www.gnu.org/licenses/>.

INSERT INTO llx_c_contact_function (rowid, pos, code, label, c_level, active) VALUES(1, 5,'EXECBOARD', 'Executive board', 0, 1);
INSERT INTO llx_c_contact_function (rowid, pos, code, label, c_level, active) VALUES(2, 10, 'MANAGDIR', 'Managing director', 1, 1);
INSERT INTO llx_c_contact_function (rowid, pos, code, label, c_level, active) VALUES(3, 15, 'ACCOUNTMANAG', 'Account manager', 0, 1);
INSERT INTO llx_c_contact_function (rowid, pos, code, label, c_level, active) VALUES(3, 20, 'ENGAGDIR', 'Engagement director', 1, 1);
INSERT INTO llx_c_contact_function (rowid, pos, code, label, c_level, active) VALUES(4, 25, 'DIRECTOR', 'Director', 1, 1);
INSERT INTO llx_c_contact_function (rowid, pos, code, label, c_level, active) VALUES(5, 30, 'PROJMANAG', 'Project manager', 0, 1);
INSERT INTO llx_c_contact_function (rowid, pos, code, label, c_level, active) VALUES(6, 35, 'DEPHEAD', 'Department head', 0, 1);
INSERT INTO llx_c_contact_function (rowid, pos, code, label, c_level, active) VALUES(7, 40, 'SECRETAR', 'Secretary', 0, 1);
INSERT INTO llx_c_contact_function (rowid, pos, code, label, c_level, active) VALUES(8, 45, 'EMPLOYEE', 'Department employee', 0, 1);

INSERT INTO llx_c_contact_department (rowid, pos, code, label, active) VALUES(1, 5,'MANAGEMENT', 'Management', 1);
INSERT INTO llx_c_contact_department (rowid, pos, code, label, active) VALUES(2, 10,'GESTION', 'Gestion', 1);
INSERT INTO llx_c_contact_department (rowid, pos, code, label, active) VALUES(3, 15,'TRAINING', 'Training', 1);
INSERT INTO llx_c_contact_department (rowid, pos, code, label, active) VALUES(4, 20,'IT', 'Inform. Technology (IT)', 1);
INSERT INTO llx_c_contact_department (rowid, pos, code, label, active) VALUES(5, 25,'MARKETING', 'Marketing', 1);
INSERT INTO llx_c_contact_department (rowid, pos, code, label, active) VALUES(6, 30,'SALES', 'Sales', 1);
INSERT INTO llx_c_contact_department (rowid, pos, code, label, active) VALUES(7, 35,'Legal', 'Legal', 1);
INSERT INTO llx_c_contact_department (rowid, pos, code, label, active) VALUES(8, 40,'FINANCIAL', 'Financial accounting', 1);
INSERT INTO llx_c_contact_department (rowid, pos, code, label, active) VALUES(9, 45,'HUMANRES', 'Human resources', 1);
INSERT INTO llx_c_contact_department (rowid, pos, code, label, active) VALUES(10, 50,'PURCHASING', 'Purchasing', 1);
INSERT INTO llx_c_contact_department (rowid, pos, code, label, active) VALUES(11, 55,'SERVICES', 'Services', 1);
INSERT INTO llx_c_contact_department (rowid, pos, code, label, active) VALUES(12, 60,'CUSTOMSERV', 'Customer service', 1);
INSERT INTO llx_c_contact_department (rowid, pos, code, label, active) VALUES(13, 65,'CONSULTING', 'Consulting', 1);
INSERT INTO llx_c_contact_department (rowid, pos, code, label, active) VALUES(14, 70,'LOGISTIC', 'Logistics', 1);
INSERT INTO llx_c_contact_department (rowid, pos, code, label, active) VALUES(15, 75,'CONSTRUCT', 'Engineering/design', 1);
INSERT INTO llx_c_contact_department (rowid, pos, code, label, active) VALUES(16, 80,'PRODUCTION', 'Manufacturing', 1);
INSERT INTO llx_c_contact_department (rowid, pos, code, label, active) VALUES(17, 85,'QUALITY', 'Quality assurance', 1);
INSERT INTO llx_c_contact_department (rowid, pos, code, label, active) VALUES(18, 85,'MAINT', 'Plant assurance', 1);
