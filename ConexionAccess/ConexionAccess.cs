using System;
using System.Collections.Generic;
using System.Data;
using System.Data.OleDb;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace POO6
{
    class ConexionAccess
    {

        private OleDbConnection connection;

        public ConexionAccess(string path)
        {
            this.connection = new OleDbConnection("Provider=Microsoft.ACE.OLEDB.12.0;Data Source=|DataDirectory|" + path);
        }

        public void open()
        {
            this.connection.Open();
        }

        public void close()
        {
            this.connection.Close();
        }

        public DataSet executeQuery(string sql)
        {
            OleDbDataAdapter adapter = new OleDbDataAdapter(sql, this.connection);

            DataSet d = new DataSet();
            adapter.Fill(d);

            return d;

        }

        public bool executeInstruction(string sql)
        {
            OleDbCommand cmd = new OleDbCommand();
            cmd.Connection = this.connection;
            cmd.CommandText = @sql;
            return cmd.ExecuteNonQuery() > 0;
        }

    }
}
