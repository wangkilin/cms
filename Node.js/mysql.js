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

function selectFirstOne (mysqlConnection)
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

mysqlConnection.on('connect', function (arg) {
    console.info(arg);
});

//process.exit();

mysqlConnection.connect(function (err) {
    if (err) {
        console.error(err.stack);
        return;
    }
    console.info(mysqlConnection.threadId);
    selectFirstOne (mysqlConnection);
    selectFirstOne (mysqlConnection);

    //mysqlConnection.destroy();  // 野蛮关闭。不等
    //mysqlConnection.end(); // 等待数据库操作后再关闭
});

connectInfo.connectionLimit = 10;
var pool = mysql.createPool (connectInfo);/*
pool.getConnection(function(err, connection) {
    if (err) {
        console.info('mysql connection with pool is failed');
        console.info(err.message);
        return;
    }
    selectFirstOne (connection);
    selectFirstOne (connection);
    selectFirstOne (connection);

   // mysqlConnection.end();
});
//pool.end(function(err){});// close all connections
*/
pool.on('connection', function (poolConnection) {
    console.info('mysql server is connected');
});
pool.on('enqueue', function () {
    console.info('enqueue event is happened');
});

// .query(sqlString, callback)
connection.query('SELECT * FROM `books` WHERE `author` = "David"', function (error, results, fields) {
  // error will be an Error if one occurred during the query
  // results will contain the results of the query
  // fields will contain information about the returned results fields (if any)
});

//.query(sqlString, values, callback)
connection.query('SELECT * FROM `books` WHERE `author` = ?', ['David'], function (error, results, fields) {
  // error will be an Error if one occurred during the query
  // results will contain the results of the query
  // fields will contain information about the returned results fields (if any)
});

//.query(options, callback)
connection.query({
  sql: 'SELECT * FROM `books` WHERE `author` = ?',
  timeout: 40000, // 40s
  values: ['David']
}, function (error, results, fields) {
  // error will be an Error if one occurred during the query
  // results will contain the results of the query
  // fields will contain information about the returned results fields (if any)
});

//.query(options, values, callback)   The values argument will override the values in the option object.
connection.query({
    sql: 'SELECT * FROM `books` WHERE `author` = ?',
    timeout: 40000, // 40s
  },
  ['David'],
  function (error, results, fields) {
    // error will be an Error if one occurred during the query
    // results will contain the results of the query
    // fields will contain information about the returned results fields (if any)
  }
);

var query = "SELECT * FROM posts WHERE title=" + mysql.escape("Hello MySQL");
var userId = 1;
connection.query('SELECT * FROM users WHERE id = ?', [userId], function(err, results) {
  // ...
});
var post  = {id: 1, title: 'Hello MySQL'};
var query = connection.query('INSERT INTO posts SET ?', post, function(err, result) {
  // Neat!
});
console.log(query.sql); // INSERT INTO posts SET `id` = 1, `title` = 'Hello MySQL'

var userId = 1;
var columns = ['username', 'email'];
var query = connection.query('SELECT ?? FROM ?? WHERE id = ?', [columns, 'users', userId], function(err, results) {
  // ...
});

console.log(result.insertId);
console.log('deleted ' + result.affectedRows + ' rows');
console.log('changed ' + result.changedRows + ' rows');


var query = connection.query('SELECT * FROM posts');
query
  .on('error', function(err) {
    // Handle error, an 'end' event will be emitted after this as well
  })
  .on('fields', function(fields) {
    // the field packets for the rows to follow
  })
  .on('result', function(row) {
    // Pausing the connnection is useful if your processing involves I/O
    connection.pause();

    processRow(row, function() {
      connection.resume();
    });
  })
  .on('end', function() {
    // all rows have been received
  });



  connection.query('SELECT 1; SELECT 2', function(err, results) {
  if (err) throw err;

  // `results` is an array with one element for every statement in the query:
  console.log(results[0]); // [{1: 1}]
  console.log(results[1]); // [{2: 2}]
});


var query = connection.query('SELECT 1; SELECT 2');

query
  .on('fields', function(fields, index) {
    // the fields for the result rows that follow
  })
  .on('result', function(row, index) {
    // index refers to the statement this result belongs to (starts at 0)
  });



connection.beginTransaction(function(err) {
  if (err) { throw err; }
  connection.query('INSERT INTO posts SET title=?', title, function(err, result) {
    if (err) {
      connection.rollback(function() {
        throw err;
      });
    }

    var log = 'Post ' + result.insertId + ' added';

    connection.query('INSERT INTO log SET data=?', log, function(err, result) {
      if (err) {
        connection.rollback(function() {
          throw err;
        });
      }
      connection.commit(function(err) {
        if (err) {
          connection.rollback(function() {
            throw err;
          });
        }
        console.log('success!');
      });
    });
  });
});