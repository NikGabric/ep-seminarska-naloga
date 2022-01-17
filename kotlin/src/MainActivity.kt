package ep.rest

import android.content.Intent
import android.os.Bundle
import android.util.Log
import android.widget.AdapterView
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import ep.rest.databinding.ActivityMainBinding
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.IOException

class MainActivity : AppCompatActivity(), Callback<List<Cube>> {
    private val tag = this::class.java.canonicalName

    private val binding by lazy { ActivityMainBinding.inflate(layoutInflater) }
    private val adapter by lazy { CubeAdapter(this) }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(binding.root)

        binding.items.adapter = adapter
        binding.items.onItemClickListener = AdapterView.OnItemClickListener { _, _, i, _ ->
            val cube = adapter.getItem(i)
            if (cube != null) {
                val intent = Intent(this, CubeDetailActivity::class.java)
                intent.putExtra("ep.rest.cube_id", cube.cube_id)
                startActivity(intent)
            }
        }

        binding.container.setOnRefreshListener { CubeService.instance.getAll().enqueue(this) }

        binding.btnSave.setOnClickListener {
            val intent = Intent(this, CubeFormActivity::class.java)
            startActivity(intent)
        }

        CubeService.instance.getAll().enqueue(this)
    }

    override fun onResponse(call: Call<List<Cube>>, response: Response<List<Cube>>) {
        if (response.isSuccessful) {
            val hits = response.body() ?: emptyList()
            Log.i(tag, "Got ${hits.size} hits")
            adapter.clear()
            adapter.addAll(hits)
        } else {
            val errorMessage = try {
                "An error occurred: ${response.errorBody()?.string()}"
            } catch (e: IOException) {
                "An error occurred: error while decoding the error message."
            }

            Toast.makeText(this, errorMessage, Toast.LENGTH_SHORT).show()
            Log.e(tag, errorMessage)
        }
        binding.container.isRefreshing = false
    }

    override fun onFailure(call: Call<List<Cube>>, t: Throwable) {
        Log.w(tag, "Error: ${t.message}", t)
        binding.container.isRefreshing = false
    }
}
