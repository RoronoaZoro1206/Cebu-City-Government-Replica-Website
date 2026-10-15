const express = require('express');
const bodyParser = require('body-parser');
const { Pool } = require('pg');
const cors = require('cors');

const app = express();
const port = 3000;

//Middleware
app.use(cors());
app.use(bodyParser.json());

//PostgreSQL connection - updated to match db.php settings
const pool = new Pool({
    user: 'postgres',
    host: 'localhost',
    database: 'Integrative_Programming',
    password: '!*Lawrence1206',
    port: 5432
});

//Route to handle feedbacks - updated to match FEEDBACK table schema
app.post('/submit-feedback', async (req, res) => {
    const { name, email, message } = req.body;

    try{
        await pool.query(
            'INSERT INTO FEEDBACK (FB_NAME, FB_EMAIL, FB_MESSAGE) VALUES ($1, $2, $3)',
            [name, email, message]
        );
        res.status(200).json({ success: true, message: 'Feedback submitted successfully.'});
    } catch (err){
        console.error(err);
        res.status(500).json({ success: false, message: 'An error occurred.'});
    }
});

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});