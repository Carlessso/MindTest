INSERT INTO system_group (id, name) VALUES( (SELECT max(g.id) + 1 FROM system_group g) , 'Básico');
INSERT INTO system_user_group (id, system_group_id, system_user_id) VALUES((SELECT max(ug.id) + 1 FROM system_user_group ug), 3, 1);
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Usuarios', 'UsuarioHeaderList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Provas', 'ProvaHeaderList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Grupos', 'GrupoHeaderList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Grupo provas', 'GrupoProvaHeaderList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Grupo usuarios', 'GrupoUsuarioHeaderList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Usuario provas', 'UsuarioProvaHeaderList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Questaos', 'QuestaoHeaderList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Respostas', 'RespostaHeaderList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Alternativas', 'AlternativaHeaderList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Questao usuario provas', 'QuestaoUsuarioProvaHeaderList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Alternativa resposta questaos', 'AlternativaRespostaQuestaoHeaderList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de resposta', 'RespostaForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de prova', 'ProvaForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de grupo', 'GrupoForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de grupo prova', 'GrupoProvaForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de grupo usuario', 'GrupoUsuarioForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de usuario prova', 'UsuarioProvaForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de questao', 'QuestaoForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de usuario', 'UsuarioForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de alternativa', 'AlternativaForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de questao usuario prova', 'QuestaoUsuarioProvaForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de alternativa resposta questao', 'AlternativaRespostaQuestaoForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p));