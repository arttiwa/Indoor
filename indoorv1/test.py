import sys
from graph import Graph
from dijkstra import dijkstra

# รับค่า src_node และ dest_node จาก command line arguments
src_node = sys.argv[1]
dest_node = sys.argv[2]

# ตัวอย่างการใช้งาน
graph = {

    # f11_f4-----------------------------------------------------
    'EleF11_f4m': {'F11_401': 6,'F11_402': 6,'F11_414': 10,'F11_415': 9,'F11_419': 5,'F11_420': 4,'F11_421': 4, 'F11_422':5, 'F11_423': 6},
    'StairF11_f4c': {'F11_401': 4,'F11_402': 4,'F11_414': 11,'F11_415': 10,'F11_419': 12,'F11_420': 12,'F11_421': 13, 'F11_422': 14, 'F11_423': 15},
    
    'F11_401': {'StairF11_f4c': 4,'EleF11_f4m': 6,'F11_402': 1,'F11_414': 8,'F11_415': 9,'F11_419': 9,'F11_420': 8,'F11_421': 8, 'F11_422': 9, 'F11_423': 13},
    'F11_402': {'StairF11_f4c': 4,'EleF11_f4m': 6,'F11_401': 1,'F11_414': 8,'F11_415': 9,'F11_419': 9,'F11_420': 8,'F11_421': 8, 'F11_422': 9, 'F11_423': 13},
    'F11_414': {'StairF11_f4c': 11,'EleF11_f4m': 10,'F11_401': 8,'F11_402': 8,'F11_415': 1,'F11_419': 5,'F11_420': 6,'F11_421': 5, 'F11_422': 8, 'F11_423': 9},
    'F11_415': {'StairF11_f4c': 10,'EleF11_f4m': 9,'F11_401': 9,'F11_402': 9,'F11_414': 1,'F11_419': 5,'F11_420': 6,'F11_421': 5, 'F11_422': 8, 'F11_423': 9},
    'F11_419': {'StairF11_f4c': 12,'EleF11_f4m': 5,'F11_401': 9,'F11_402': 9,'F11_414': 5,'F11_415': 5,'F11_420': 1,'F11_421': 3, 'F11_422': 5, 'F11_423': 6},
    'F11_420': {'StairF11_f4c': 12,'EleF11_f4m': 4,'F11_401': 8,'F11_402': 8,'F11_414': 6,'F11_415': 6,'F11_419': 1,'F11_421': 2, 'F11_422':4, 'F11_423': 5},
    'F11_421': {'StairF11_f4c': 13,'EleF11_f4m': 4,'F11_401': 8,'F11_402': 8,'F11_414': 5,'F11_415': 5,'F11_419': 3,'F11_420': 2, 'F11_422': 1, 'F11_423': 2},
    'F11_422': {'StairF11_f4c': 14,'EleF11_f4m': 5,'F11_401': 9,'F11_402': 9,'F11_414': 8,'F11_415': 8,'F11_419': 5,'F11_420': 4,'F11_421': 1, 'F11_423': 4},
    'F11_423': {'StairF11_f4c': 15,'EleF11_f4m': 6,'F11_401': 10,'F11_402': 10,'F11_414': 9,'F11_415': 9,'F11_419': 6,'F11_420': 5,'F11_421': 2, 'F11_422': 1},
    
    # f11_f1
    'A': {'B': 1, 'C': 4},
    'B': {'A': 1, 'C': 2, 'D': 5},
    'C': {'A': 4, 'B': 2, 'D': 1},
    'D': {'B': 5, 'C': 1}
}
graph_obj = Graph(graph)
shortest_path = dijkstra(graph_obj, src_node, dest_node)
print(shortest_path)