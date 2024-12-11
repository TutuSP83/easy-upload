const express = require('express');
const bodyParser = require('body-parser');
const sqlite3 = require('sqlite3').verbose();
const cors = require('cors');
const app = express();
const PORT = 3000;

// Middleware
app.use(cors());
app.use(bodyParser.json());

// Banco de Dados
const db = new sqlite3.Database('./data.db');

// Criação das tabelas
db.serialize(() => {
  db.run(`CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL
  )`);

  db.run(`CREATE TABLE IF NOT EXISTS files (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    file_name TEXT NOT NULL,
    file_url TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id)
  )`);
});

// Rota para cadastrar um novo usuário
app.post('/register', (req, res) => {
  const { username, password } = req.body;

  db.run(
    `INSERT INTO users (username, password) VALUES (?, ?)`,
    [username, password],
    function (err) {
      if (err) {
        return res.status(400).json({ error: 'Usuário já existe!' });
      }
      res.json({ message: 'Usuário registrado com sucesso!' });
    }
  );
});

// Rota para login
app.post('/login', (req, res) => {
  const { username, password } = req.body;

  db.get(
    `SELECT * FROM users WHERE username = ? AND password = ?`,
    [username, password],
    (err, row) => {
      if (err || !row) {
        return res.status(401).json({ error: 'Credenciais inválidas!' });
      }
      res.json({ message: 'Login bem-sucedido!', user: row });
    }
  );
});

// Rota para obter arquivos do usuário
app.get('/files/:userId', (req, res) => {
  const { userId } = req.params;

  db.all(`SELECT * FROM files WHERE user_id = ?`, [userId], (err, rows) => {
    if (err) {
      return res.status(500).json({ error: 'Erro ao buscar arquivos.' });
    }
    res.json(rows);
  });
});

// Rota para adicionar arquivos
app.post('/files', (req, res) => {
  const { userId, fileName, fileUrl } = req.body;

  db.run(
    `INSERT INTO files (user_id, file_name, file_url) VALUES (?, ?, ?)`,
    [userId, fileName, fileUrl],
    function (err) {
      if (err) {
        return res.status(500).json({ error: 'Erro ao salvar arquivo.' });
      }
      res.json({ message: 'Arquivo salvo com sucesso!', fileId: this.lastID });
    }
  );
});

// Rota para excluir arquivo
app.delete('/files/:fileId', (req, res) => {
  const { fileId } = req.params;

  db.run(`DELETE FROM files WHERE id = ?`, [fileId], function (err) {
    if (err) {
      return res.status(500).json({ error: 'Erro ao excluir arquivo.' });
    }
    res.json({ message: 'Arquivo excluído com sucesso.' });
  });
});

// Iniciar servidor
app.listen(PORT, () => {
  console.log(`Servidor rodando em http://localhost:${PORT}`);
});
