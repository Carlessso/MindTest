create table log_aluno_prova(
id serial not null,
descricao text not null,
usuario_id integer not null,
data_operacao timestamp without time zone not null default now(),
PRIMARY KEY(id),
FOREIGN KEY (usuario_id) REFERENCES usuario(id));