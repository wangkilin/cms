/**
 * https://github.com/felixge/node-mysql
 * npm install mysql
 */
var mysql = require('mysql');
var connectInfo = {
    host : 'localhost',
    user : 'root',
    password : '',
    database : 'mysql',
    charset  : 'utf8_general_ci'
};

var mysqlConnection = mysql.createConnection (connectInfo);

function selectFirstOne ()
{
    console.info('当前毫秒：%d', (new Date()).getMilliseconds());
    mysqlConnection.query('SELECT * FROM user LIMIT 0,1', function (error, rows) {
        if (error) {
            console.error('query error:' + error.stack);
            return;
        }

        //console.info(rows);

        //console.info(typeof rows);
        for (var length=0; length<rows.length; length++) {
            console.info('Host:' + rows[length].Host);
        }

        //mysqlConnection.destroy();
    });
}

mysqlConnection.connect(function (err) {
    if (err) {
        console.error(err.stack);
        return;
    }
    console.info(mysqlConnection.threadId);
    selectFirstOne ();
    selectFirstOne ();

    //mysqlConnection.destroy();  // 野蛮关闭。不等
    mysqlConnection.end(); // 等待数据库操作后再关闭
});

connectInfo.connectionLimit = 10;
var pool = mysql.createPool (connectInfo);
pool.getConnection(function(err, connection) {
    if (err) {
        console.info('mysql connection with pool is failed');
        console.info(err.message);
        return;
    }
    selectFirstOne ();

   // mysqlConnection.end();
});
//pool.end();// close all connections
